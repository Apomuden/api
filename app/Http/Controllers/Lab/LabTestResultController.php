<?php

namespace App\Http\Controllers\Lab;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiResponse;
use App\Http\Requests\Lab\LabResultMultipleRequest;
use App\Http\Requests\Lab\LabResultRequest;
use App\Http\Resources\Lab\labTestResultResource;
use App\Models\LabTestResult;
use App\Repositories\RepositoryEloquent;
use Illuminate\Support\Facades\DB;

class LabTestResultController extends Controller
{
    protected $repository;

    public function __construct(LabTestResult $labTestResult)
    {
        $this->repository = new RepositoryEloquent($labTestResult);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $records=$this->repository->all('parameter_order');

        return ApiResponse::withOk('Lab results list',labTestResultResource::collection($records));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(LabResultRequest $request)
    {
        $record=LabTestResult::updateOrCreate([
            'investigation_id' => $request->investigation_id,
            'lab_parameter_id' => $request->lab_parameter_id,
        ],$request->except(['investigation_id', 'lab_parameter_id']));

        return ApiResponse::withOk('Lab result created',new labTestResultResource($record->refresh()));
    }

    public function storeMultiple(LabResultMultipleRequest $request)
    {
        DB::beginTransaction();
        $results = $request->results;
        $results_ids = [];
        foreach ($results as $result) {
            $result=(array) $result;
            $record = LabTestResult::updateOrCreate([
                'investigation_id' => $request->investigation_id,
                'lab_parameter_id' => $result['lab_parameter_id'],
            ], $request->except(['investigation_id', 'results'])+$result);

            $results_ids[] = $record->id;
        }
        DB::commit();
        $records = $this->repository->getModel()->whereIn('id', $results_ids)->orderBy('parameter_order')->get();
        return ApiResponse::withOk('Lab results created', labTestResultResource::collection($records));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $record = $this->repository->find($id);
        return ApiResponse::withOk('Lab result found', new labTestResultResource($record));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(LabResultRequest $request, $id)
    {
        $record = $this->repository->update($request->all(),$id);
        return ApiResponse::withOk('Lab result updated', new labTestResultResource($record));
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
        return ApiResponse::withOk('Lab result deleted');
    }
}
