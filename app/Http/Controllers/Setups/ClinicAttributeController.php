<?php

namespace App\Http\Controllers\Setups;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiRequest;
use App\Http\Helpers\ApiResponse;
use App\Http\Requests\Clinic\ClinicAttributeRequest;
use App\Http\Resources\ClinicAttributeResource;
use App\Http\Resources\ClinicAttributeCollection;
use App\Models\ClinicAttribute;
use App\Repositories\RepositoryEloquent;
use Illuminate\Http\Request;

class ClinicAttributeController extends Controller
{
    protected $repository;
    public function __construct(ClinicAttribute $clinicAttribute)
    {
        $this->repository = new RepositoryEloquent($clinicAttribute);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return ApiResponse::withOk('Clinic Attribute list', new ClinicAttributeCollection($this->repository->all('name')));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(ClinicAttributeRequest $request)
    {
        $requestData = ApiRequest::asArray($request);

        $response = $this->repository->store($requestData);

        return  ApiResponse::withOk('Clinic Attribute created', new ClinicAttributeResource($response));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ClinicAttribute  $clinicAttribute
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(ClinicAttribute $clinicAttribute)
    {
        $ClinicAttribute = $this->repository->show($clinicAttribute);
        return $ClinicAttribute ?
            ApiResponse::withOk('Clinic Attribute Found', new ClinicAttributeResource($clinicAttribute))
            : ApiResponse::withNotFound('Clinic Attribute Not Found');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ClinicAttribute  $clinicAttribute
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(ClinicAttributeRequest $request, ClinicAttribute $clinicAttribute)
    {
        try{
            $company = $this->repository->update($request->all(), $clinicAttribute->id);

            return ApiResponse::withOk('Clinic Attribute updated', new ClinicAttributeResource($clinicAttribute));

        }
        catch(Exception $e){
            return ApiResponse::withException($e);
        }
    }

    public function destroy($id)
    {
        $this->repository->delete($id);
        return ApiResponse::withOk('Clinic Attribute deleted successfully');
    }

}
