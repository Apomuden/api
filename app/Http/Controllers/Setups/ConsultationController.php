<?php

namespace App\Http\Controllers\Setups;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiRequest;
use App\Http\Helpers\ApiResponse;
use App\Http\Requests\Clinic\ConsultationRequest;
use App\Http\Resources\ConsultationResource;
use App\Http\Resources\ConsultationCollection;
use App\Models\Consultation;
use App\Repositories\RepositoryEloquent;
use Exception;
use Illuminate\Http\Request;
//use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Route as FacadeRoute;

class ConsultationController extends Controller
{
    protected $repository;
    public function __construct(Consultation $consultation)
    {
        $this->repository = new RepositoryEloquent($consultation);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $routeName = FacadeRoute::currentRouteName();
        if ($routeName === "consultationsericerequests.index") {
            return ApiResponse::withOk('Consultation Service Requests list', new ConsultationCollection($this->repository->findWhere('name')));
        }
        else {
            return ApiResponse::withOk('Consultation Service list', new ConsultationCollection($this->repository->all('name')));
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(ConsultationRequest $request)
    {
        $response = $this->repository->store($request->all());

        return  ApiResponse::withOk('Consultation Service created', new ConsultationResource($response->refresh()));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Consultation  $consultation
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $consultation = $this->repository->show($id);

        return $consultation ?
            ApiResponse::withOk('Consultation Service Found', new ConsultationResource($consultation))
            : ApiResponse::withNotFound('Consultation Service Not Found');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Consultation  $consultation
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(ConsultationRequest $request, $consultation)
    {
        try{

            $consultation = $this->repository->update($request->all(), $consultation);

            return ApiResponse::withOk('Consultation Service updated', new ConsultationResource($consultation));

        }
        catch(Exception $e){
            return ApiResponse::withException($e);
        }
    }

    public function destroy($id)
    {
        $this->repository->delete($id);
        return ApiResponse::withOk('Consultation Service deleted successfully');
    }

}
