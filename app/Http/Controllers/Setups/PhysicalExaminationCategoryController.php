<?php

namespace App\Http\Controllers\Setups;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiResponse;
use App\Http\Requests\Setups\PhysicalExaminationCategoryRequest;
use App\Http\Resources\GeneralResource;
use App\Models\PhysicalExaminationCategory;
use App\Repositories\RepositoryEloquent;

class PhysicalExaminationCategoryController extends Controller
{
    protected $repository;
    public function __construct(PhysicalExaminationCategory $physicalExaminationCategory)
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
        $records=$this->repository->all('name');
        return ApiResponse::withOk('Physical Examinations categories list',GeneralResource::collection($records));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PhysicalExaminationCategoryRequest $request)
    {
        $record=$this->repository->store($request->all());
        return ApiResponse::withOk('Physical Examinations category created',new GeneralResource($record));
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
        return ApiResponse::withOk('Physical Examinations category found',new GeneralResource($record));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PhysicalExaminationCategoryRequest $request, $id)
    {
        $record=$this->repository->update($request->all(),$id);
        return ApiResponse::withOk('Physical Examinations category updated', new GeneralResource($record));
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
        return ApiResponse::withOk('Physical Examinations category deleted');
    }
}
