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
use Illuminate\Support\Facades\DB;

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

    public function byAttendanceDate(Request $request)
    {
        $searchParams = \request()->query();
        $attendanceDate = $searchParams['attendance_date']??null;
        $patientID = $searchParams['patient_id']??null;
        unset($searchParams['attendance_date'],$searchParams['patient_id']);

        //DB::enableQueryLog();
        $this->repository->setModel(PatientVital::findBy($searchParams)->where(function ($query) use ($patientID, $attendanceDate) {
            $query->whereDate('created_at', $attendanceDate);
            if ($patientID) {
                $query->where('patient_id', $patientID);
            }
        }));

        $records= $this->repository->getModel()->get();
        //return [DB::getQueryLog()];
        return ApiResponse::withOk('Found Patient Vitals', PatientVitalResource::collection($records));

    }

    public function store(PatientVitalRequest $patientVitalRequest){
        try{
            $requestData=$patientVitalRequest->all();
            $patientVital=$this->repository->store($requestData);
            return ApiResponse::withOk('Patient Vitals created',new PatientVitalResource($patientVital->refresh()));
        }
        catch(Exception $e){
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
