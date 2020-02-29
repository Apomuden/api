<?php

namespace App\Http\Controllers\Registration;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiResponse;
use App\Http\Requests\Registrations\PatientVitalRequest;
use App\Http\Resources\Registrations\PatientVitalCollection;
use App\Http\Resources\Registrations\PatientVitalResource;
use App\Models\PatientVital;
use App\Repositories\RepositoryEloquent;
use Exception;
use Illuminate\Http\Request;

class PatientVitalController extends Controller
{
    protected $repository;

    public function __construct(PatientVital $patientVital)
    {
        $this->repository= new RepositoryEloquent($patientVital);
    }

    public function index(){

        return ApiResponse::withOk('Patient Vitals list',new PatientVitalCollection($this->repository->all('name')));
    }

    public function show($patientVital){
        $patientVital=$this->repository->show($patientVital);
        return $patientVital?
            ApiResponse::withOk('Patient Vitals Found',new PatientVitalResource($patientVital))
            : ApiResponse::withNotFound('Patient Vitals Not Found');
    }

    public function store(PatientVitalRequest $patientVitalRequest){
        try{
            $requestData=$patientVitalRequest->all();
            $patientVital=$this->repository->store($requestData);
            return ApiResponse::withOk('Patient Vitals created',new PatientVitalResource($patientVital->refresh()));
        }
        catch(Exception $e){
            dd(null);
            return ApiResponse::withException($e);
        }
    }

    public function update(PatientVitalRequest $patientVitalRequest,$patientVital){
        try{
            $patientVital=$this->repository->update($patientVitalRequest->all(),$patientVital);
            return ApiResponse::withOk('Patient Vitals updated',new PatientVitalResource($patientVital));
        }
        catch(Exception $e){
            return ApiResponse::withException($e);
        }
    }
    public function destroy($id)
    {
        $this->repository->delete($id);
        return ApiResponse::withOk('Patient Vital deleted successfully');
    }
}
