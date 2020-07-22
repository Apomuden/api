<?php

namespace App\Http\Controllers\Registration;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiResponse;
use App\Http\Requests\Registrations\PatientNextOfKinRequest;
use App\Http\Resources\Registrations\PatientNextOfKinResource;
use App\Models\PatientNextOfKin;
use App\Repositories\RepositoryEloquent;

class PatientNextOfKinController extends Controller
{
    protected $repository;
    public function __construct()
    {
        $this->repository = new RepositoryEloquent(new PatientNextOfKin(), true, ['relationship','patient']);
    }
    public function index()
    {
        $patients = $this->repository->all('name');
        return ApiResponse::withOk('Patient Next of Kins List', PatientNextOfKinResource::collection($patients));
    }
    public function store(PatientNextOfKinRequest $request)
    {
        $patient = $this->repository->store($request->all());
        return ApiResponse::withOk('Patient Next of Kin created', new PatientNextOfKinResource($patient->refresh()));
    }

    public function show($patientnextofkin)
    {
        $patient = $this->repository->find($patientnextofkin);
        return ApiResponse::withOk('Patient Next of Kin found', new PatientNextOfKinResource($patient));
    }

    public function update(PatientNextOfKinRequest $request, $patientnextofkin)
    {
        $patient = $this->repository->update($request->all(), $patientnextofkin);
        return ApiResponse::withOk('Patient Next of Kin updated', new PatientNextOfKinResource($patient));
    }

    public function destroy($id)
    {
        $this->repository->delete($id);
        return ApiResponse::withOk('Patient deleted successfully');
    }
}
