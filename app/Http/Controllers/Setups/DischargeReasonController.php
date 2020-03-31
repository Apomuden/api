<?php

namespace App\Http\Controllers\Setups;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiResponse;
use App\Http\Requests\Setups\DischargeReasonRequest;
use App\Http\Resources\DischargeReasonResource;
use App\Models\DischargeReason;
use App\Repositories\RepositoryEloquent;

class DischargeReasonController extends Controller
{
    protected $repository;
    public function __construct(DischargeReason $dischargeReason)
    {
        $this->repository = new RepositoryEloquent($dischargeReason);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $records=$this->repository->all('name');
        return ApiResponse::withOk('Discharge reasons list',DischargeReasonResource::collection($records));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DischargeReasonRequest $request)
    {
        $record=$this->repository->store($request->all());
        return ApiResponse::withOk('Discharge reasons created',new DischargeReasonResource($record));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $record = $this->repository->show($id);
        return ApiResponse::withOk('Discharge reason found',new DischargeReasonResource($record));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(DischargeReasonRequest $request, $id)
    {
        $record=$this->repository->update($request->all(),$id);
        return ApiResponse::withOk('Discharge reason updated', new DischargeReasonResource($record));
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
        return ApiResponse::withOk('Discharge reason deleted');
    }
}
