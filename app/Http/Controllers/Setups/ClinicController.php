<?php

namespace App\Http\Controllers\Setups;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiRequest;
use App\Http\Helpers\ApiResponse;
use App\Http\Requests\Clinic\ClinicRequest;
use App\Http\Resources\ClinicResource;
use App\Http\Resources\ClinicCollection;
use App\Models\Clinic;
use App\Repositories\RepositoryEloquent;
use Exception;
use Illuminate\Http\Request;

class ClinicController extends Controller
{
    protected $repository;
    public function __construct(Clinic $clinic)
    {
        $this->repository = new RepositoryEloquent($clinic);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return ApiResponse::withOk('Clinic list', new ClinicCollection($this->repository->all('name')));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(ClinicRequest $request)
    {
        $response = $this->repository->store($request->all());

        return  ApiResponse::withOk('Clinic created', new ClinicResource($response));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Clinic  $clinic
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $Clinic = $this->repository->show($id);
        return $Clinic ?
            ApiResponse::withOk('Clinic Found', new ClinicResource($id))
            : ApiResponse::withNotFound('Clinic Not Found');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Clinic  $clinic
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(ClinicRequest $request,$id)
    {
        try{
            $clinic = $this->repository->update($request->all(), $id);

            return ApiResponse::withOk('Clinic updated', new ClinicResource($clinic));

        }
        catch(Exception $e){
            return ApiResponse::withException($e);
        }
    }

    public function destroy($id)
    {
        $this->repository->delete($id);
        return ApiResponse::withOk('Clinic deleted successfully');
    }

}
