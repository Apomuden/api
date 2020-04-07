<?php

namespace App\Http\Controllers\Registration;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiResponse;
use App\Http\Requests\ApiFormRequest;
use App\Http\Requests\Registrations\PatientHistoryRequest;
use App\Http\Resources\PatientResource;
use App\Http\Resources\Registrations\PatientHistoryResource;
use App\Models\PatientHistory;
use App\Repositories\RepositoryEloquent;

class PatientHistoryController extends Controller
{
    protected $repository;
    public function __construct(PatientHistory $patientHistory)
    {
        $this->repository = new RepositoryEloquent($patientHistory);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return ApiResponse::withOk('Patient history list', PatientHistoryResource::collection($this->repository->all('created_at')));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PatientHistoryRequest $request)
    {
        $record=$this->repository->store($request->all());
        return ApiResponse::withOk('Patient history created',new PatientHistoryResource($record));
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
        return ApiResponse::withOk('Patient history found',new PatientHistoryResource($record));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PatientHistoryRequest $request, $id)
    {
        $record=$this->repository->update($request->all(),$id);
        return ApiResponse::withOk('patient history updated',new PatientHistoryResource($record));
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
        return ApiResponse::withOk('Patient history deleted successfully');
    }
}
