<?php

namespace App\Http\Controllers\Pricing;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiResponse;
use App\Http\Helpers\DateHelper;
use App\Http\Requests\Lab\LabServiceParameterRequest;
use App\Http\Requests\Lab\LabServiceSampleTypeRequest;
use App\Http\Requests\Pricing\ServiceRequest;
use App\Http\Resources\Lab\LabParameterResource;
use App\Http\Resources\Lab\LabSampleTypeResource;
use App\Http\Resources\ServiceCollection;
use App\Http\Resources\ServiceResource;
use App\Models\Clinic;
use App\Models\ClinicService;
use App\Models\NhisAccreditationSetting;
use App\Models\Patient;
use App\Models\Service;
use App\Repositories\RepositoryEloquent;

class ServiceController extends Controller
{
    protected $repository;

    public function __construct(Service $service)
    {
        $this->repository = new RepositoryEloquent($service);
    }

    public function index()
    {
        $services = $this->repository->all('description');

        return ApiResponse::withOk('Service List', new ServiceCollection($services));
    }

    //getting services by patient age and gender
    function getServicesApplicableToPatient(){
        $clinic_id = request('clinic_id');
        $patient_id = request('patient_id');
        $age = request('age');
        $gender = request('gender');
        $status=request('status');
        $patient_status=request('patient_status');


        if($patient_id)
        {
            $patient= (new RepositoryEloquent(new Patient))->find($patient_id);
            $age=$age??$patient->age;

            $gender=$gender??$patient->gender;
        }

        $age_groups = DateHelper::getAgeGroups(DateHelper::getDOB($age));

        $in_age_groups=[];
        if ($age_groups) {
            foreach ($age_groups as $age_group)
                $in_age_groups[] = $age_group->id;
        }

        if($clinic_id){
            $services = Service::whereHas('clinic_services',function($q1) use($clinic_id){
                $q1->where('clinic_id',$clinic_id);
            })->orderBy('services.description');
        }
        else
        $services=Service::orderBy('services.description');

        if($in_age_groups)
        $services=$services->whereIn('age_group_id',$in_age_groups);


        if($status)
        $services=$services->whereStatus($status);


        $findBy=[];

        if($patient_status)
        $findBy['patient_status'] = "={$patient_status}";

        if($gender)
        $findBy['gender']= "={$gender}";

        if($findBy)
        $services=$services->findBy($findBy);

        $services=$services->get();

        return ApiResponse::withOk('Service List', new ServiceCollection($services));

    }
    function getPrice()
    {
        $patient_id = request('patient_id');
        $service_id = request('service_id');
        $billing_sponsor_id = request('billing_sponsor_id');

        $fee = 0;
        $patient = Patient::find($patient_id);
        if ($patient) {
            $PatientActiveNhis = $patient->patient_sponsors()
                ->where('status', 'ACTIVE')
                ->where('billing_sponsor_id', $billing_sponsor_id)
                ->whereHas('billing_sponsor', function ($q1) {
                    $q1->whereHas('sponsorship_type', function ($q2) {
                        $q2->whereName('Government Insurance');
                    });
                })->where('expiry_date', '>=', today())->first();

            $service = Service::find($service_id);

            if ($PatientActiveNhis) {
                $age = $patient->age;

                $nhisSettings = NhisAccreditationSetting::first();

                if ($age > 12) {
                    $fee = $service->nhis_adult_tariff->nhis_provider_level_tariffs()
                        ->where('nhis_provider_level_id', $nhisSettings->nhis_provider_level_id)->first()->tariff ?? 0.00;
                } else {
                    $fee = $service->nhis_child_tariff->nhis_provider_level_tariffs()
                        ->where('nhis_provider_level_id', $nhisSettings->nhis_provider_level_id)->first()->tariff ?? 0.00;
                }
            } elseif ($billing_sponsor_id) {
                $hasPostPaid = $patient->patient_sponsors()
                    ->where('status', 'ACTIVE')
                    ->where('billing_sponsor_id', $billing_sponsor_id)->first();

                if ($hasPostPaid) {
                    $fee = $service->postpaid_amount;
                }
            }
            $fee = $service->prepaid_amount;
        }
        return ApiResponse::withOk('Service Fee', floatVal($fee));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(ServiceRequest $request)
    {
        $servicePrice = $this->repository->store($request->all());
        return ApiResponse::withOk('Service created', new ServiceResource($servicePrice->refresh()));
    }
    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($serviceprice)
    {
        $servicePrice = $this->repository->find($serviceprice);
        return ApiResponse::withOk('Found service', new ServiceResource($servicePrice));
    }

    public function labParametersList($service_id)
    {
        $service = $this->repository->findOrFail($service_id);
        return ApiResponse::withOk('Lab parameters list', LabParameterResource::collection($service->lab_parameters()->orderBy('lab_service_parameters.order')->get()));
    }

    public function labSampleTypesList($service_id)
    {
        $service = $this->repository->findOrFail($service_id);
        return ApiResponse::withOk('Lab sample types list', LabSampleTypeResource::collection($service->lab_sample_types()->orderBy('lab_service_sample_types.order')->get()));
    }

    public function labParametersStore(LabServiceParameterRequest $request, $service_id)
    {
        $service = $this->repository->findOrFail($service_id);
        $service->lab_parameters()->syncWithoutDetaching($request->parameters);

        return ApiResponse::withOk('Lab parameter(s) created', LabParameterResource::collection($service->lab_parameters()->whereIn('id', array_keys($request->parameters))->orderBy('lab_service_parameters.order')->get()));
    }

    public function labSampleTypesStore(LabServiceSampleTypeRequest $request, $service_id)
    {
        $service = $this->repository->findOrFail($service_id);
        $service->lab_sample_types()->syncWithoutDetaching($request->sample_types);

        return ApiResponse::withOk('Lab sample type(s) created', LabSampleTypeResource::collection($service->lab_sample_types()->whereIn('id', array_keys($request->sample_types))->orderBy('lab_service_sample_types.order')->get()));
    }

    public function labParametersDelete(LabServiceParameterRequest $request, $service_id)
    {
        $service = $this->repository->findOrFail($service_id);
        $service->lab_parameters()->detach($request->parameters);
        return ApiResponse::withOk('Lab parameter(s) deleted Successfully');
    }

    public function labSampleTypesDelete(LabServiceSampleTypeRequest $request, $service_id)
    {
        $service = $this->repository->findOrFail($service_id);
        $service->lab_sample_types()->detach($request->sample_types);
        return ApiResponse::withOk('Lab sample type(s) deleted Successfully');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(ServiceRequest $request, $serviceprice)
    {
        $servicePrice = $this->repository->update($request->all(), $serviceprice);
        return ApiResponse::withOk('Found service updated', new ServiceResource($servicePrice));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->repository->delete($id);
        return ApiResponse::withOk('Service deleted successfully');
    }
}
