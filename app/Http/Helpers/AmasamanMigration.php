<?php

namespace App\Http\Helpers;

use App\Jobs\AmasamanMigrationJob;
use App\Models\EducationalLevel;
use App\Models\Folder;
use App\Models\FundingType;
use App\Models\Patient;
use App\Models\PatientNextOfKin;
use App\Models\Profession;
use App\Models\Relationship;
use App\Models\Religion;
use App\Models\Title;
use App\Models\User;
use App\Repositories\RepositoryEloquent;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class AmasamanMigration{

    private $maleTitleId, $feMaleTitleId,$cashFundingTypeId,$user,$token;
    function __construct()
    {
        $this->maleTitleId= Title::whereName('Mr')->first()->id;
        $this->feMaleTitleId= Title::whereName('Miss')->first()->id;
        $this->cashFundingTypeId=FundingType::whereName('CASH/PREPAID')->first()->id;

        $this->user=User::where('username', 'hmwpb')->first();
        $this->token=auth('api')->login($this->user);
    }
    function getPatients(){
      return DB::select('select * from patients_old  order by folder_num');
    }
    function createPatient($patient){

        if(in_array(strtoupper(trim($patient['first_name'])),['NANA ADJOA', 'DORA', 'EUNICE', 'VICTORIA', 'SEQUENCIA', 'PAOLA']))
            $patient['gender']='Female';
        $payload=[
            'title_id'=> trim($patient['gender'])?($patient['gender']=='Male'? $this->maleTitleId: $this->feMaleTitleId):null,
            'funding_type_id'=> $this->cashFundingTypeId,
            'folder_type'=> 'INDIVIDUAL',
            'surname'=>trim($patient['last_name'])?:null,
            'middlename'=>trim($patient['middle_name']),
            'firstname'=>trim($patient['first_name']),
            'dob'=> trim($patient['dob'])?Carbon::parse(trim($patient['dob']))->format('Y-m-d'):null,
            'gender'=> trim($patient['gender'])?:null,
            'reg_status'=> 'OUT-PATIENT',
            'religion_id'=> trim($patient['religion'])? Religion::findBy(['name' => $patient['religion']=='Islamic'?'Islam': $patient['religion']])->firstOrCreate(['name'=> $patient['religion']])->id:null,
            'profession_id'=>Profession::whereName($patient['occupation'])->first()->id?? Profession::whereName('other')->first()->id,
            'marital'=>$patient['maritalstatus']== 'Widowed' && $patient['gender'] == 'Male'?'WIDOWER':($patient['maritalstatus']== 'Co-habitation'? 'OTHER':(trim($patient['maritalstatus'])== 'Widowed'?'WIDOW':(strtoupper(trim($patient['maritalstatus']))?:null))),
            'educational_level_id'=> EducationalLevel::findby(['name' => $patient['educationallevel']=='None'?'Other':$patient['educationallevel']])->firstOrCreate(['name'=> $patient['educationallevel']=='Tertiary'?'Tertiary Education':($patient['educationallevel']== 'Senior High'? 'SECONDARY EDUCATION':($patient['educationallevel']== 'Junior High'? 'MIDDLE SCHOOL LEVER': (strtoupper($patient['educationallevel'])??null)))])->id,
            'active_cell'=>is_numeric(trim($patient['contact']))?intval(trim($patient['contact'])):null,
            'email'=>!Str::contains('@', trim($patient['email']))?null: trim($patient['email']),
            'residence_address'=>trim($patient['location'])?:null,
            'old_folder_no'=>trim($patient['folder_num']),
            'created_at'=>Carbon::parse(trim($patient['createdAt']))->format('Y-m-d H:i:s')??now(),
            'updated_at'=> Carbon::parse(trim($patient['updatedAt']))->format('Y-m-d H:i:s')??null
        ];

        Log::alert('Payload', $payload);


        $patientCreated=Patient::where([
            'surname'=> trim($patient['last_name']),
            'firstname'=> trim($patient['first_name']),
            'dob'=> trim($patient['dob']),
            'active_cell'=> trim($patient['contact'])
        ])->first();

        if(!$patientCreated){
            DB::beginTransaction();
            $this->repository=new RepositoryEloquent(new Folder());

            $folder = $this->repository->store(['folder_type' => $payload['folder_type']]);

            //Add Patient
            $payload['folder_id'] = $folder->id;
            unset($payload['folder_type']);

            $this->repository->setModel(new Patient());
            $Newpatient = $this->repository->store($payload);
            //$response = HttpClient::post(route('patients.withfolder'), $payload, ["Authorization: Bearer {$this->token}", 'Accept: application/json', 'Content-Type: application/json']);

            Log::alert('New Patient',$Newpatient->toArray());
            if ($Newpatient) {
                $patient_id = $Newpatient->id;
                PatientNextOfKin::create([
                    'name' => preg_replace("/[^A-Za-z0-9 ]/", "", trim($patient['nextofking'])),
                    'phone' => is_numeric(trim($patient['nokcontact'])) ? intval(trim($patient['nokcontact'])): null,
                    'patient_id' => $patient_id,
                    'relation_id' => Relationship::whereName(trim($patient['relationship']))->firstOrCreate(['name' => strtoupper($patient['relationship'])])->id,
                    'created_at' => Carbon::parse(trim($patient['createdAt']))->format('Y-m-d H:i:s') ?? now(),
                    'updated_at' => Carbon::parse(trim($patient['updatedAt']))->format('Y-m-d H:i:s') ?? null
                ]);

                DB::update('update patients_old set migrated = 1,patient_id='.$patient_id.' where id = ?', [$patient['id']]);
                Log::alert('Old Patient', $patient);
                DB::commit();

                return true;
            }
        }


    }

    static function run(){
         $migrationObj=new Self;
         $patients=$migrationObj->getPatients();

         $counter=1;
         foreach($patients as $patient){
             $patient=(array) $patient;
             dispatch(new AmasamanMigrationJob($patient));

             Log::alert('Total Processed',[$counter++]);
         }
    }
}
