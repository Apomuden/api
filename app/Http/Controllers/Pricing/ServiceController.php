<?php

namespace App\Http\Controllers\Pricing;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiResponse;
use App\Http\Requests\Lab\LabSampleTypeRequest;
use App\Http\Requests\Lab\LabServiceParameterRequest;
use App\Http\Requests\Lab\LabServiceSampleTypeRequest;
use App\Http\Requests\Pricing\ServiceRequest;
use App\Http\Requests\Setups\ConsultationServiceComponentsRequest;
use App\Http\Resources\Lab\LabParameterResource;
use App\Http\Resources\Lab\LabSampleTypeResource;
use App\Http\Resources\ServiceCollection;
use App\Http\Resources\ServiceConsultationComponentResource;
use App\Http\Resources\ServiceResource;
use App\Models\LabParameter;
use App\Models\Service;
use App\Repositories\RepositoryEloquent;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    protected $repository;

    public function __construct(Service $service){
          $this->repository=new RepositoryEloquent($service);
    }
    public function index()
    {
       $services=$this->repository->all('description');

       return ApiResponse::withOk('Service List',new ServiceCollection($services));
    }

    /* public function search(){
       $params=request()->query();
       $servicePrices=$this->repository->getModel()->findBy($params)->orderBy('description')->get();
       return ApiResponse::withOk('Service Prices List',new ServicePriceCollection($servicePrices));
    } */

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ServiceRequest $request)
    {
       $servicePrice=$this->repository->store($request->all());
       return ApiResponse::withOk('Service created',new ServiceResource($servicePrice->refresh()));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($serviceprice)
    {
        $servicePrice=$this->repository->find($serviceprice);
        return ApiResponse::withOk('Found service',new ServiceResource($servicePrice));
    }

    public function labParametersList($service_id){
        $service = $this->repository->findOrFail($service_id);
        return ApiResponse::withOk('Lab parameters list',LabParameterResource::collection($service->lab_parameters()->orderBy('lab_service_parameters.order')->get()));
    }
    public function labSampleTypesList($service_id){
        $service = $this->repository->findOrFail($service_id);
        return ApiResponse::withOk('Lab sample types list',LabSampleTypeResource::collection($service->lab_sample_types()->orderBy('lab_service_sample_types.order')->get()));
    }

    public function labParametersStore(LabServiceParameterRequest $request,$service_id){
        $service = $this->repository->findOrFail($service_id);
        $service->lab_parameters()->syncWithoutDetaching($request->parameters);

        return ApiResponse::withOk('Lab parameter(s) created',LabParameterResource::collection($service->lab_parameters()->whereIn('id',array_keys($request->parameters))->orderBy('lab_service_parameters.order')->get()));
    }

    public function labSampleTypesStore(LabServiceSampleTypeRequest $request, $service_id)
    {
        $service = $this->repository->findOrFail($service_id);
        $service->lab_sample_types()->syncWithoutDetaching($request->sample_types);

        return ApiResponse::withOk('Lab sample type(s) created', LabSampleTypeResource::collection($service->lab_sample_types()->whereIn('id', array_keys($request->sample_types))->orderBy('lab_service_sample_types.order')->get()));
    }

    public function labParametersDelete(LabServiceParameterRequest $request,$service_id)
    {
        $service = $this->repository->findOrFail($service_id);
        $service->lab_parameters()->detach($request->parameters);
        return ApiResponse::withOk('Lab parameter(s) deleted Successfully');
    }

    public function labSampleTypesDelete(LabServiceSampleTypeRequest $request,$service_id)
    {
        $service = $this->repository->findOrFail($service_id);
        $service->lab_sample_types()->detach($request->sample_types);
        return ApiResponse::withOk('Lab sample type(s) deleted Successfully');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ServiceRequest $request,$serviceprice)
    {
       $servicePrice=$this->repository->update($request->all(),$serviceprice);
       return ApiResponse::withOk('Found service updated',new ServiceResource($servicePrice));
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
        return ApiResponse::withOk('Service deleted successfully');
    }


    ////////////////////////////
    // consultation components
    public function componentsList($service_id)
    {
        $service = $this->repository->findOrFail($service_id);
        return ApiResponse::withOk('Components list', ServiceConsultationComponentResource::collection($service->consultation_components()
            ->orderBy('services_consultation_components.order')->get()));
    }

    public function saveComponents(ConsultationServiceComponentsRequest $request, $service_id)
    {
        $service = $this->repository->findOrFail($service_id);
        $service->consultation_components()->syncWithoutDetaching($request->components);

        return ApiResponse::withOk('Components list', ServiceConsultationComponentResource::collection($service->consultation_components()
            ->whereIn('id', array_keys($request->components))->orderBy('services_consultation_components.order')->get()));
    }

    public function detachComponents(ConsultationServiceComponentsRequest $request, $service_id)
    {
        $service = $this->repository->findOrFail($service_id);
        $service->consultation_components()->detach($request->components);
        return ApiResponse::withOk('Components detached');
    }
}
