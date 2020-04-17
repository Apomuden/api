<?php

namespace App\Http\Controllers\Lab;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiResponse;
use App\Http\Requests\Lab\LabParameterRequest;
use App\Http\Requests\Lab\LabSampleTypeRequest;
use App\Http\Resources\GeneralResource;
use App\Models\LabSampleType;
use App\Repositories\RepositoryEloquent;

class LabSampleTypeController extends Controller
{
    protected $repository;

    public function __construct(LabSampleType $labSampleType)
    {
        $this->repository = new RepositoryEloquent($labSampleType);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $records=$this->repository->all('name');
        return ApiResponse::withOk('Lab Sample type list',GeneralResource::collection($records));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(LabSampleTypeRequest $request)
    {
        $record=$this->repository->store($request->all());
        return ApiResponse::withOk('Lab Sample type created',new GeneralResource($record));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $record = $this->repository->findOrFail($id);
        return ApiResponse::withOk('Lab Sample type found', new GeneralResource($record));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(LabSampleTypeRequest $request, $id)
    {
        $record = $this->repository->update($request->all(),$id);
        return ApiResponse::withOk('Lab Sample type updated', new GeneralResource($record));
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
        return ApiResponse::withOk('Lab Sample type deleted');
    }
}
