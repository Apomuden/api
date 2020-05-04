<?php

namespace App\Http\Controllers\Lab;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiResponse;
use App\Http\Helpers\IDGenerator;
use App\Http\Requests\Lab\LabTestSampleMultipleRequest;
use App\Http\Requests\Lab\LabTestSampleRequest;
use App\Http\Resources\Lab\labTestSampleResource;
use App\Models\LabTestSample;
use App\Repositories\RepositoryEloquent;
use Illuminate\Support\Facades\Artisan;

class LabTestSampleController extends Controller
{
    protected $repository;

    public function __construct(LabTestSample $labSample)
    {
        $this->repository = new RepositoryEloquent($labSample);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $records=$this->repository->all('name');
        return ApiResponse::withOk('Lab Test Sample list',labTestSampleResource::collection($records));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(LabTestSampleRequest $request)
    {
        $record=$this->repository->store($request->all());
        return ApiResponse::withOk('Lab Test Sample created',new labTestSampleResource($record->refresh()));
    }
    public function storeMultiple(LabTestSampleMultipleRequest $request)
    {
        $tests=$request->tests;
        $record_ids=[];
        foreach($tests as $test){
            $test=(array) $test;

            $samples=(array)$test['samples'];
            foreach($samples as $sample){
                $sample=(array) $sample;
                $payload= $sample+['investigation_id'=>$test['investigation_id']];

                if(isset($request->technician_id))
                $payload['technician_id']= $request->technician_id;

                $record = $this->repository->store($payload);
                $record_ids[]=$record->id;
            }
        }
        Artisan::call('cache:clear');
        return ApiResponse::withOk('Lab Test Sample created',labTestSampleResource::collection($this->repository->getModel()->whereIn('id',$record_ids)->orderBy('lab_sample_type_order')->get()));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $record = $this->repository->findOrFail($id);
        return ApiResponse::withOk('Lab Test Sample found', new labTestSampleResource($record));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(LabTestSampleRequest $request, $id)
    {
        $record = $this->repository->update($request->all(),$id);
        return ApiResponse::withOk('Lab Test Sample updated', new labTestSampleResource($record));
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
        return ApiResponse::withOk('Lab Test Sample deleted');
    }
}
