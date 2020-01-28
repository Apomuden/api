<?php

namespace App\Http\Controllers\Registration;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiResponse;
use App\Http\Requests\Registrations\PatientSponsorMultipleRequest;
use App\Http\Requests\Registrations\PatientSponsorRequest;
use App\Http\Resources\PatientSponsorResource;
use App\Models\PatientSponsor;
use App\Models\Relationship;
use App\Models\SponsorshipPolicy;
use App\Repositories\RepositoryEloquent;
use Illuminate\Support\Facades\DB;

class PatientSponsorController extends Controller
{
    protected $repository;
    public function __construct(PatientSponsor $patientSponsor)
    {
      $this->repository=new RepositoryEloquent($patientSponsor);
    }
    public function index()
    {

       return ApiResponse::withOk('Patient sponsors list',PatientSponsorResource::collection($this->repository->all('member_id')));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PatientSponsorRequest $request)
    {
       $sponsor= $this->repository->store($request->all());

      return ApiResponse::withOk('Patient sponsor created',new PatientSponsorResource($sponsor->refresh()));
    }

    public function storeMultiple(PatientSponsorMultipleRequest $request){
        DB::beginTransaction();

        //Creating records
        $patient_id=$request['patient_id'];
        $sponsors = $request['sponsors'];

        $repository=new RepositoryEloquent(new Relationship);
        $mother_relation=$repository->showWhere(['name'=>'mother'])->first();

        $repositoryPolicy = new RepositoryEloquent(new SponsorshipPolicy);

        $repositorySponsor = new RepositoryEloquent(new PatientSponsor);

        $iterator=0;
        $patient_ids=[];
        foreach($sponsors as $sponsor){
            if($sponsor['benefit_type']=='BABY' && $sponsor['relation_id']!=$mother_relation->id)
            return ApiResponse::withValidationError([['sponsors.'.$iterator.'.relation_id'=> 'The selected sponsors.' . $iterator . '.relation_id is not correct for Baby Benefit type']]);

            elseif($sponsor['benefit_type'] != 'BABY' && $repositorySponsor->findWhere(['member_id' => $sponsor['member_id']])->first())
                return ApiResponse::withValidationError([['sponsors.' . $iterator . '.member_id' => ['The selected sponsors.' . $iterator . '.member_id already exists']]]);
            elseif ($sponsor['benefit_type'] != 'BABY' && $repositorySponsor->findWhere(['card_serial_no' => $sponsor['card_serial_no']])->first())
                return ApiResponse::withValidationError([['sponsors.' . $iterator . '.card_serial_no' => ['The selected sponsors.' . $iterator . '.card_serial_no no already exists']]]);

            $policiesCount = $repositoryPolicy->findWhere(['billing_sponsor_id' => $sponsor['billing_sponsor_id']])->count();
            if($policiesCount && !($sponsor['sponsorship_policy_id']??null))
            return ApiResponse::withValidationError([['sponsors.' . $iterator . '.sponsorship_policy_id' => ['The sponsors.' . $iterator . '.sponsorship_policy_id is required']]]);


            $sponsor['patient_id']=$patient_id;
            $sponsor=$this->repository->store($sponsor);
            $patient_ids[]=$sponsor->id;
            $iterator++;
        }
        DB::commit();

        $sponsors= $this->repository->getModel()->whereIn('id',$patient_ids)->orderBy('priority')->get();
        return ApiResponse::withOk('Patient sponsors created', PatientSponsorResource::collection($sponsors));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $patientsponsor
     * @return \Illuminate\Http\Response
     */
    public function show($patientsponsor)
    {
        $patientsponsor=$this->repository->find($patientsponsor);
        return ApiResponse::withOk('Patient sponsor found', new PatientSponsorResource($patientsponsor));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $patientsponsor
     * @return \Illuminate\Http\Response
     */
    public function update(PatientSponsorRequest $request, $patientsponsor)
    {
        $patientsponsor=$this->repository->update($request->all(),$patientsponsor);
        return ApiResponse::withOk('Patient sponsor updated', new PatientSponsorResource($patientsponsor));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $patientsponsor
     * @return \Illuminate\Http\Response
     */
    public function destroy($patientsponsor)
    {
       $patientsponsor=$this->repository->delete($patientsponsor);
        return ApiResponse::withOk('Patient sponsor deleted successfully');
    }
}
