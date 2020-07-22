<?php

namespace App\Http\Controllers\Setups;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiResponse;
use App\Http\Requests\Setups\PhysicalExaminationTypeRequest;
use App\Http\Resources\PhysicalExaminationTypeResource;
use App\Models\PhysicalExaminationType;
use App\Repositories\RepositoryEloquent;

class PhysicalExaminationTypeController extends Controller
{
    protected $repository;
    public function __construct(PhysicalExaminationType $physicalExaminationCategory)
    {
        $this->repository = new RepositoryEloquent($physicalExaminationCategory);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $records = $this->repository->all('name');
        return ApiResponse::withOk('Physical Examinations types list', PhysicalExaminationTypeResource::collection($records));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PhysicalExaminationTypeRequest $request)
    {
        $record = $this->repository->store($request->all());
        return ApiResponse::withOk('Physical Examinations type created', new PhysicalExaminationTypeResource($record));
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
        return ApiResponse::withOk('Physical Examinations type found', new PhysicalExaminationTypeResource($record));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PhysicalExaminationTypeRequest $request, $id)
    {
        $record = $this->repository->update($request->all(), $id);
        return ApiResponse::withOk('Physical Examinations type updated', new PhysicalExaminationTypeResource($record));
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
        return ApiResponse::withOk('Physical Examinations type deleted');
    }
}
