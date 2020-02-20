<?php

namespace App\Http\Controllers\Setups;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiResponse;
use App\Http\Requests\Clinic\ClinicServiceMultipleRequest;
use App\Http\Requests\Clinic\ClinicServiceRequest;
use App\Http\Resources\ClinicServiceResource;
use App\Models\ClinicService;
use App\Repositories\RepositoryEloquent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClinicServiceController extends Controller
{
    protected $repository;
    public function __construct(ClinicService $clinicService)
    {
        $this->repository = new RepositoryEloquent($clinicService,true,['clinic','main_clinic', 'consultation_service', 'billing_cycle']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $records=$this->repository->all('consultation_service_id');
        return ApiResponse::withOk('Clinic services list',ClinicServiceResource::collection($records));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ClinicServiceRequest $request)
    {
       $record=$this->repository->store($request->all());
       return ApiResponse::withOk('Clinic service created',new ClinicServiceResource($record->refresh()));
    }

    public function storeMultiple(ClinicServiceMultipleRequest $request){
        DB::beginTransaction();
        $clinic_id=$request->clinic_id;
        $services=$request->services;
        foreach($services as $service){
            $service=(object) $service;
            $this->repository->store([
                'clinic_id'=>$clinic_id,
                'service_id'=>$service->service_id,
                'billing_cycle_id'=>$service->billing_cycle_id,
                'billing_duration'=>$service->billing_duration
            ]);
        }
        DB::commit();
        $records = $this->repository->all('consultation_service_id');
        return ApiResponse::withOk('Clinic services created', ClinicServiceResource::collection($records));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $record=$this->repository->findOrFail($id);
        return ApiResponse::withOk('Clinic service found', new ClinicServiceResource($record));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ClinicServiceRequest $request, $id)
    {
        $record=$this->repository->update($request->all(), $id);
        return ApiResponse::withOk('Clinic service updated', new ClinicServiceResource($record));
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
        return ApiResponse::withOk('Clinic service deleted');
    }
}
