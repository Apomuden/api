<?php

namespace App\Http\Controllers\Registration;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiResponse;
use App\Http\Requests\Registrations\PatientRequest;
use App\Http\Resources\PatientPaginatedCollection;
use App\Http\Resources\PatientResource;
use App\Models\Patient;
use App\Repositories\RepositoryEloquent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PatientController extends Controller
{
    protected $repository,$withCallback,$searchParams=[];
    public function __construct()
    {

      $this->searchParams=\request()->query();

      $folder_no=$this->searchParams['folder_no']??null;
      $rack_no=$this->searchParams['rack_no']??null;
      $folder_type=$this->searchParams['folder_type']??null;

       unset($this->searchParams['folder_no'],
       $this->searchParams['rack_no'],
       $this->searchParams['folder_type']
       );

       $folderSearch=[];
       if($folder_no)
       $folderSearch['folder_no']=$folder_no;

       if($rack_no)
       $folderSearch['rack_no']=$rack_no;

       if($folder_type)
       $folderSearch['folder_type']=$folder_type;

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
           'folders'=>$this->withCallback
       ];
       $this->repository=new RepositoryEloquent(new Patient,true,$with);

    }
    public function index()
    {
      //DB::enableQueryLog();
      $this->repository->useFindBy=false;
      $this->repository->setModel(Patient::findBy($this->searchParams)->whereHas('folders',$this->withCallback));
      $patients=$this->repository->all('surname');

      //return [DB::getQueryLog()];
      return ApiResponse::withOk('Patients List',PatientResource::collection($patients));
    }

    public function paginated()
    {
      $this->repository->setModel(Patient::whereHas('folders',$this->withCallback));
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
        //
    }
}
