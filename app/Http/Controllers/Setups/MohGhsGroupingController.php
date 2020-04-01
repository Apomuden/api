<?php

namespace App\Http\Controllers\Setups;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiResponse;
use App\Http\Requests\Setups\MohGhsGroupingRequest;
use App\Http\Resources\GeneralResource;
use App\Models\MohGhsGrouping;
use App\Repositories\RepositoryEloquent;
use Illuminate\Http\Request;

class MohGhsGroupingController extends Controller
{
    protected $repository;
    public function __construct(MohGhsGrouping $mohGhsGrouping)
    {
        $this->repository = new RepositoryEloquent($mohGhsGrouping);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $records=$this->repository->all('name');
        return ApiResponse::withOk('MohGhs Grouping list',GeneralResource::collection($records));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MohGhsGroupingRequest $request)
    {
        $record=$this->repository->store($request->all());
        return ApiResponse::withOk('Moh Ghs Created',new GeneralResource($record));
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
        return ApiResponse::withOk('Moh Ghs found', new GeneralResource($record));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(MohGhsGroupingRequest $request, $id)
    {
        $record = $this->repository->update($request->all(),$id);
        return ApiResponse::withOk('Moh Ghs updated', new GeneralResource($record));
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
        return ApiResponse::withOk('Moh Ghs deleted');
    }
}
