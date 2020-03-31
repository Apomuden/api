<?php

namespace App\Http\Controllers\Registration;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiResponse;
use App\Http\Requests\Registrations\PhysicalExaminationMultipleRequest;
use App\Http\Requests\Registrations\PhysicalExaminationRequest;
use App\Http\Resources\Registrations\PhysicalExaminationResource;
use App\Models\PhysicalExamination;
use App\Repositories\RepositoryEloquent;

class PhysicalExaminationController extends Controller
{
    protected $repository;
    public function __construct(PhysicalExamination $physicalExamination)
    {
        $this->repository = new RepositoryEloquent($physicalExamination);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return ApiResponse::withOk('Physical Examination list', PhysicalExaminationResource::collection($this->repository->all('created_at')));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PhysicalExaminationRequest $request)
    {
        $record=$this->repository->store($request->all());
        return ApiResponse::withOk('Physical Examination created',new PhysicalExaminationResource($record));
    }
    public function storeMultiple(PhysicalExaminationMultipleRequest  $request)
    {

        $payload= $request->except(['consultation_id', 'patient_status', 'consultation_date', 'consultant_id']);

        $record_ids=[];
        foreach($payload['exams'] as $exam){
            $exam=$exam + $request->only(['consultation_id', 'patient_status', 'consultation_date', 'consultant_id']);
            $record = $this->repository->store($exam);
            $record_ids[]=$record->id;
        }
        $records=$this->repository->getModel()->whereIn('id',$record_ids)->get();
        return ApiResponse::withOk('Physical Examinations created',PhysicalExaminationResource::collection($records));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $record=$this->repository->show($id);
        return ApiResponse::withOk('Physical Examination found',new PhysicalExaminationResource($record));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PhysicalExaminationRequest $request, $id)
    {
        $record=$this->repository->update($request->all(),$id);
        return ApiResponse::withOk('Physical Examination updated',new PhysicalExaminationResource($record));
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
        return ApiResponse::withOk('Physical Examination deleted successfully');
    }
}
