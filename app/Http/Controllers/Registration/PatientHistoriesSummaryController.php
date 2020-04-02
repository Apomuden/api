<?php

namespace App\Http\Controllers\Registration;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiResponse;
use App\Http\Requests\ApiFormRequest;
use App\Http\Requests\Registrations\PatientHistoriesSummaryRequest;
use App\Http\Resources\PatientResource;
use App\Http\Resources\Registrations\PatientHistoriesSummaryResource;
use App\Models\PatientHistoriesSummary;
use App\Repositories\RepositoryEloquent;

class PatientHistoriesSummaryController extends Controller
{
    protected $repository;
    public function __construct(PatientHistoriesSummary $patientHistoriesSummary)
    {
        $this->repository = new RepositoryEloquent($patientHistoriesSummary);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return ApiResponse::withOk('Patient histories summary list', PatientHistoriesSummaryResource::collection($this->repository->all('created_at')));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PatientHistoriesSummaryRequest $request)
    {
        $record=$this->repository->store($request->all());
        return ApiResponse::withOk('Patient histories summary created',new PatientHistoriesSummaryResource($record));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $record=$this->repository->getModel()->where('patient_id',$id)->first();
        return ApiResponse::withOk('Patient histories summary found',new PatientHistoriesSummaryResource($record));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PatientHistoriesSummaryRequest $request, $id)
    {
        $record=$this->repository->getModel()->where('patient_id',$id)->update($request->all());
        return ApiResponse::withOk('patient histories summary updated',new PatientHistoriesSummaryResource($record));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->repository->getModel()->where('patient_id',$id)->destroy();
        return ApiResponse::withOk('Patient histories summary deleted successfully');
    }
}
