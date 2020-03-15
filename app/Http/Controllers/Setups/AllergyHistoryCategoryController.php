<?php

namespace App\Http\Controllers\Setups;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiResponse;
use App\Http\Requests\Setups\AllergyHistoryCategoryRequest;
use App\Http\Resources\GeneralResource;
use App\Models\AllergyHistoryCategory;
use App\Repositories\RepositoryEloquent;

class AllergyHistoryCategoryController extends Controller
{
    protected $repository;
    public function __construct(AllergyHistoryCategory $AllergyHistoryCategory)
    {
        $this->repository = new RepositoryEloquent($AllergyHistoryCategory);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $records=$this->repository->all('name');
        return ApiResponse::withOk('Allergy history categories list',GeneralResource::collection($records));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AllergyHistoryCategoryRequest $request)
    {
        $record=$this->repository->store($request->all());
        return ApiResponse::withOk('Allergy history category created',new GeneralResource($record));
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
        return ApiResponse::withOk('Allergy history category found',new GeneralResource($record));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AllergyHistoryCategoryRequest $request, $id)
    {
        $record=$this->repository->update($request->all(),$id);
        return ApiResponse::withOk('Allergy history category updated', new GeneralResource($record));
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
        return ApiResponse::withOk('Allergy history category deleted');
    }
}
