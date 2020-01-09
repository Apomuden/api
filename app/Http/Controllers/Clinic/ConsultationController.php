<?php

namespace App\Http\Controllers\Clinic;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiRequest;
use App\Http\Helpers\ApiResponse;
use App\Http\Requests\Clinic\ConsultationRequest;
use App\Http\Resources\ConsultationResource;
use App\Http\Resources\ConsultationCollection;
use App\Models\Consultation;
use App\Repositories\RepositoryEloquent;
use Illuminate\Http\Request;

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
     * @return
     */
    public function index(Consultation $consultation)
    {
        return ApiResponse::withOk('Consultation Services list', new ConsultationCollection($this->repository->all('name')));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return
     */
    public function store(ConsultationRequest $request)
    {
        $requestData = ApiRequest::asArray($request);
        $response = $this->repository->store($requestData);

        return  ApiResponse::withOk('Consultation service record created', new ConsultationResource($response));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Consultation  $consultation
     * @return
     */
    public function show(Consultation $consultation)
    {
        $Consultation = $this->repository->show($consultation);
        return $Consultation ?
            ApiResponse::withOk('Consultation service record Found', new ConsultationResource($consultation))
            : ApiResponse::withNotFound('No record found');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Consultation  $consultation
     * @return
     */
    public function update(ConsultationRequest $request, Consultation $consultation)
    {
        try{
            $company = $this->repository->update($request->all(), $consultation->id);

            return ApiResponse::withOk('Consultation service record updated', new ConsultationResource($consultation));

        }
        catch(Exception $e){
            return ApiResponse::withException($e);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Consultation  $consultation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Consultation $consultation)
    {
        //
    }
}
