<?php

namespace App\Http\Controllers\Clinic;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiRequest;
use App\Http\Helpers\ApiResponse;
use App\Http\Requests\Clinic\ClinicRequest;
use App\Http\Resources\ClinicResource;
use App\Http\Resources\ClinicCollection;
use App\Models\Clinic;
use App\Repositories\RepositoryEloquent;
use Illuminate\Http\Request;

class ClinicController extends Controller
{
    protected $repository;
    public function __construct(Clinic $clinic)
    {
        $this->repository= new RepositoryEloquent($clinic);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return ApiResponse::withOk('Clinic list',new ClinicCollection($this->repository->all('name')));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ClinicRequest $request)
    {
        $requestData=ApiRequest::asArray($request);

        //$requestData['logo']=FileResolver::base64ToFile($request->logo);

        $response=$this->repository->store($request);

        return  ApiResponse::withOk('Clinic created', new ClinicResource($response));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Clinic  $clinic
     * @return \Illuminate\Http\Response
     */
    public function show(Clinic $clinic)
    {
        $Clinic=$this->repository->show($clinic);//pass the country
        return $Clinic?
            ApiResponse::withOk('Clinic Found',new ClinicResource($clinic))
            : ApiResponse::withNotFound('Clinic Not Found');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Clinic  $clinic
     * @return \Illuminate\Http\Response
     */
    public function edit(Clinic $clinic)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Clinic  $clinic
     * @return \Illuminate\Http\Response
     */
    public function update(ClinicRequest $request, Clinic $clinic)
    {
        try{
            $company=$this->repository->update($request->all(),$clinic);

            return ApiResponse::withOk('Clinic updated',new ClincResource($clinic));

        }
        catch(Exception $e){
            return ApiResponse::withException($e);
        }
    }

}