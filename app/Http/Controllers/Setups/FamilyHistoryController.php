<?php

namespace App\Http\Controllers\Setups;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiResponse;
use App\Http\Requests\Setups\FamilyHistoryCategoryRequest;
use App\Http\Requests\Setups\FamilyHistoryRequest;
use App\Http\Resources\FamilyHistoryResource;
use App\Models\FamilyHistory;
use App\Repositories\RepositoryEloquent;

class FamilyHistoryController extends Controller
{
    protected $repository;
    public function __construct(FamilyHistory $FamilyHistory)
    {
        $this->repository = new RepositoryEloquent($FamilyHistory);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $records = $this->repository->all('name');
        return ApiResponse::withOk('Family histories list', FamilyHistoryResource::collection($records));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(FamilyHistoryRequest $request)
    {
        $record = $this->repository->store($request->all());
        return ApiResponse::withOk('Family history created', new FamilyHistoryResource($record));
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
        return ApiResponse::withOk('Family history found', new FamilyHistoryResource($record));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(FamilyHistoryRequest $request, $id)
    {
        $record = $this->repository->update($request->all(), $id);
        return ApiResponse::withOk('Family history updated', new FamilyHistoryResource($record));
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
        return ApiResponse::withOk('Family history deleted');
    }
}
