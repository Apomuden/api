<?php

namespace App\Http\Controllers\Lab;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiResponse;
use App\Http\Requests\Lab\LabParameterRangeRequest;
use App\Http\Resources\Lab\LabParameterRangeResource;
use App\Models\LabParameterRange;
use App\Repositories\RepositoryEloquent;

class LabParameterRangeController extends Controller
{
    protected $repository;

    public function __construct(LabParameterRange $labParameterRange)
    {
        $this->repository = new RepositoryEloquent($labParameterRange);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $records = $this->repository->all('name');
        return ApiResponse::withOk('Lab Parameter Ranges list', LabParameterRangeResource::collection($records));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(LabParameterRangeRequest $request)
    {
        $record = $this->repository->store($request->all());
        return ApiResponse::withOk('Lab parameter Range created', new LabParameterRangeResource($record));
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
        return ApiResponse::withOk('Lab parameter Range found', new LabParameterRangeResource($record));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(LabParameterRangeRequest $request, $id)
    {
        $record = $this->repository->update($request->all(), $id);
        return ApiResponse::withOk('Lab parameter Range updated', new LabParameterRangeResource($record));
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
        return ApiResponse::withOk('Lab parameter Range deleted');
    }
}
