<?php

namespace App\Http\Controllers\Setups;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiResponse;
use App\Http\Requests\Setups\Icd10GroupingRequest;
use App\Http\Resources\GeneralResource;
use App\Models\Icd10Grouping;
use App\Repositories\RepositoryEloquent;

class Icd10GroupingController extends Controller
{
    protected $repository;
    public function __construct(Icd10Grouping $icd10Grouping)
    {
        $this->repository = new RepositoryEloquent($icd10Grouping);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $records = $this->repository->all('name');
        return ApiResponse::withOk('Icd10 Grouping list', GeneralResource::collection($records));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Icd10GroupingRequest $request)
    {
        $record = $this->repository->store($request->all());
        return ApiResponse::withOk('Icd10 Created', new GeneralResource($record));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $record = $this->repository->find($id);
        return ApiResponse::withOk('Icd10 found', new GeneralResource($record));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Icd10GroupingRequest $request, $id)
    {
        $record = $this->repository->update($request->all(), $id);
        return ApiResponse::withOk('Icd10 updated', new GeneralResource($record));
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
        return ApiResponse::withOk('Icd10 deleted');
    }
}
