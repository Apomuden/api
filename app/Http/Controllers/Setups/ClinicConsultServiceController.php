<?php

namespace App\Http\Controllers\Setups;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiRequest;
use App\Http\Helpers\ApiResponse;
use App\Http\Requests\Clinic\ClinicConsultServiceRequest;
use App\Http\Resources\ClinicConsultServiceResource;
use App\Http\Resources\ClinicConsultServiceCollection;
use App\Models\ClinicConsultService;
use App\Repositories\RepositoryEloquent;
use Exception;
use Illuminate\Http\Request;

class ClinicConsultServiceController extends Controller
{
    protected $repository;
    public function __construct(ClinicConsultService $clinicConsultService)
    {
        $this->repository = new RepositoryEloquent($clinicConsultService);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return ApiResponse::withOk('Clinic Consultation Service list', new ClinicConsultServiceCollection($this->repository->all('name')));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(ClinicConsultServiceRequest $request)
    {
        $response = $this->repository->store($request->all());

        return  ApiResponse::withOk('Clinic Consultation Service created', new ClinicConsultServiceResource($response));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ClinicConsultService  $clinicConsultService
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $ClinicConsultService = $this->repository->show($id);
        return $ClinicConsultService ?
            ApiResponse::withOk('Clinic Consultation Service Found', new ClinicConsultServiceResource($id))
            : ApiResponse::withNotFound('Clinic Consultation Service Not Found');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ClinicConsultService  $clinicConsultService
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(ClinicConsultServiceRequest $request,$id)
    {
        try{
            $clinicConsultService = $this->repository->update($request->all(), $id);

            return ApiResponse::withOk('Clinic Consultation Service updated', new ClinicConsultServiceResource($clinicConsultService));

        }
        catch(Exception $e){
            return ApiResponse::withException($e);
        }
    }

    public function destroy($id)
    {
        $this->repository->delete($id);
        return ApiResponse::withOk('Clinic Consultation Service deleted successfully');
    }

}
