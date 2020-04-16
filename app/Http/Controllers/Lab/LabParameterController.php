<?php

namespace App\Http\Controllers\Lab;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiResponse;
use App\Http\Requests\Lab\LabParameterRequest;
use App\Http\Resources\Lab\LabParameterResource;
use App\Models\LabParameter;
use App\Repositories\RepositoryEloquent;
use Illuminate\Http\Request;

class LabParameterController extends Controller
{
    protected $repository;

    public function __construct(LabParameter $labParameter)
    {
        $this->repository = new RepositoryEloquent($labParameter);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $records=$this->repository->all('name');
        return ApiResponse::withOk('Lab paramters list',LabParameterResource::collection($records));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(LabParameterRequest $request)
    {
        $record=$this->repository->store($request->all());
        return ApiResponse::withOk('Lab paramter created',new LabParameterResource($record));
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
        return ApiResponse::withOk('Lab paramter found', new LabParameterResource($record));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(LabParameterRequest $request, $id)
    {
        $record = $this->repository->update($request->all(),$id);
        return ApiResponse::withOk('Lab paramter updated', new LabParameterResource($record));
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
        return ApiResponse::withOk('Lab paramter deleted');
    }
}
