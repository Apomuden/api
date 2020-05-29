<?php

namespace App\Http\Controllers\Registration;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiResponse;
use App\Http\Requests\Clinic\PatientNoteRequest;
use App\Http\Resources\Clinic\PatientNoteSummaryResource;
use App\Models\PatientNote;
use App\Models\PatientClinicalNoteSummary;
use App\Repositories\RepositoryEloquent;

class PatientNoteSummaryController extends Controller
{
    protected $repository;
    public function __construct(PatientClinicalNoteSummary $patientPatientNoteSummary)
    {
        $this->repository = new RepositoryEloquent($patientPatientNoteSummary);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return ApiResponse::withOk('Patient notes summary list',PatientNoteSummaryResource::collection($this->repository->all('created_at')));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    // public function store(PatientNoteRequest $request)
    // {
    //     $record=$this->repository->store($request->all());
    //     return ApiResponse::withOk('Patient note created',new PatientNoteSummaryResource($record->refresh()));
    // }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $record = $this->repository->getModel()->where('patient_id',$id)->first();
        return ApiResponse::withOk('Patient note summary found', new PatientNoteSummaryResource($record));
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function update(PatientNoteRequest $request, $id)
    // {
    //    $record=$this->repository->update($request->all(),$id);
    //    return ApiResponse::withOk('Patient note updated', new PatientNoteSummaryResource($record));
    // }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->repository->delete($id);
        return ApiResponse::withOk('Patient note summary deleted');
    }
}
