<?php

namespace App\Http\Controllers\Setups;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiResponse;
use App\Http\Requests\Setups\ComplaintTypeRequest;
use App\Http\Requests\Setups\IllnessTypeRequest;
use App\Http\Resources\ComplaintTypeResource;
use App\Models\ComplaintType;
use App\Repositories\RepositoryEloquent;

class ComplaintTypeController extends Controller
{
    protected $repository;
    public function __construct(ComplaintType $complaintType)
    {
        $this->repository = new RepositoryEloquent($complaintType);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $records=$this->repository->all('name');
        return ApiResponse::withOk('Complaint types list',ComplaintTypeResource::collection($records));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(IllnessTypeRequest $request)
    {
        $record=$this->repository->store($request->all());
        return ApiResponse::withOk('Complaint type created',new ComplaintTypeResource($record));
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
        return ApiResponse::withOk('Complaint type found',new ComplaintTypeResource($record));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ComplaintTypeRequest $request, $id)
    {
        $record=$this->repository->update($request->all(),$id);
        return ApiResponse::withOk('Complaint type updated', new ComplaintTypeResource($record));
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
        return ApiResponse::withOk('Complaint type deleted');
    }
}
