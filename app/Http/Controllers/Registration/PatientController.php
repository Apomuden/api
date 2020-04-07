<?php

namespace App\Http\Controllers\Registration;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiResponse;
use App\Http\Requests\Registrations\PatientRequest;
use App\Http\Requests\Registrations\PatientWithFolderRequest;
use App\Http\Resources\PatientPaginatedCollection;
use App\Http\Resources\PatientResource;
use App\Models\Folder;
use App\Models\Patient;
use App\Repositories\RepositoryEloquent;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PatientController extends Controller
{
    protected $repository,$withCallback,$searchParams=[];
    public function __construct()
    {

      $this->searchParams=\request()->all();


      $folder_no=$this->searchParams['folder_no']??null;
      $rack_no=$this->searchParams['rack_no']??null;
      $folder_type=$this->searchParams['folder_type']??null;

      //Folder Postfix of patient
      $postfix= $folder_no? substr($folder_no, -1):null;

       unset(
           $this->searchParams['folder_no'],
           $this->searchParams['rack_no'],
           $this->searchParams['folder_type']
       );

       $folderSearch=[];
       if($folder_no)
       $folderSearch['folder_no']='='.$folder_no;

       if($postfix && !is_numeric(trim($postfix))){
            $this->searchParams['postfix'] = '=' . trim($postfix);
            $folderSearch['folder_no']=rtrim($folderSearch['folder_no'],$postfix);
       }

       if($rack_no)
       $folderSearch['rack_no']=$rack_no;

       if($folder_type)
       $folderSearch['folder_type']=$folder_type;

     if($folderSearch)
      $this->withCallback=function($query) use($folderSearch) {
          $query->findBy($folderSearch);
       };

       $with=[
           'country',
           'region',
           'district',
           'title',
           'id_type',
           'religion',
           'educational_level',
           'emerg_relation',
           'hometown',
           'profession',
           'sponsorship_type',
           'funding_type',
           'billing_system',
           'billing_cycle',
           'payment_style',
           'payment_channel',
           'native_language',
           'second_language',
           'official_language',
           'folders'
       ];

       if($this->withCallback)
       $with['folders']= $this->withCallback;

       $this->repository=new RepositoryEloquent(new Patient,true,$with);

    }
    public function index()
    {
      //DB::enableQueryLog();
      //Arr::except($this->searchParams,['folder_no', 'rack_no', 'folder_type']);
        //Log::info('Filter', $this->searchParams);
       $this->repository->useFindBy=false;

      //Enforce folder search only when folder params are specified
      if($this->withCallback)
            $this->repository->setModel(Patient::findBy($this->searchParams)->whereHas('folders', $this->withCallback));
      else
        $this->repository->setModel(Patient::findBy($this->searchParams));

      $patients=$this->repository->all('surname');
      //return [DB::getQueryLog()];
      return ApiResponse::withOk('Patients List',PatientResource::collection($patients));
    }
    public function paginated()
    {
      $this->repository->useFindBy = false;
        //Enforce folder search only when folder params are specified
        if ($this->withCallback)
            $this->repository->setModel(Patient::findBy($this->searchParams)->whereHas('folders', $this->withCallback));
        else
            $this->repository->setModel(Patient::findBy($this->searchParams));

        return ApiResponse::withPaginate(new PatientPaginatedCollection($this->repository->paginate(10,'surname'),'Patients List'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PatientRequest $request)
    {
       $patient=$this->repository->store($request->all());

       return ApiResponse::withOk('Patient created',new PatientResource($patient->refresh()));
    }

    public function storePatientWithFolder(PatientWithFolderRequest $request){
        try{
            DB::beginTransaction();
            //Create Folder
            $this->repository->setModel(new Folder);
            $payload = ['folder_type' => $request->folder_type];
            $folder = $this->repository->store($payload);

            //Add Patient
            $payload = $request->all();
            $payload['folder_id'] = $folder->id;
            unset($payload['folder_type']);

            $this->repository->setModel(new Patient);
            $patient = $this->repository->store($payload);

            DB::commit();
            return ApiResponse::withOk('Patient created', new PatientResource($patient->refresh()));
        }
       catch(Exception $e){
           DB::rollback();
           return ApiResponse::withException($e);
       }
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($patient)
    {
        $patient=$this->repository->find($patient);
        return ApiResponse::withOk('Patient found',new PatientResource($patient));
    }
    public function findByFolder(){
       //
        $this->repository->setModel(Patient::findBy($this->searchParams)->whereHas('folders', $this->withCallback));
        $patientCount = $this->repository->count();
        $patient=$this->repository->first();

        if($patientCount==1)
          return ApiResponse::withOk('Patient found', new PatientResource($patient));
        else
          return ApiResponse::withNotFound(null);


    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PatientRequest $request, $patient)
    {
        $patient=$this->repository->update($request->all(),$patient);
        return ApiResponse::withOk('Patient updated',new PatientResource($patient));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->repository->delete($id);
        return ApiResponse::withOk('Patient deleted successfully');
    }
}
