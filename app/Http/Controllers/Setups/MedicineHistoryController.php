<?php

namespace App\Http\Controllers\Setups;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiResponse;
use App\Http\Requests\Setups\MedicineHistoryCategoryRequest;
use App\Http\Resources\MedicineHistoryResource;
use App\Models\MedicineHistory;
use App\Repositories\RepositoryEloquent;

class MedicineHistoryController extends Controller
{
    protected $repository;
    public function __construct(MedicineHistory $MedicineHistory)
    {
        $this->repository = new RepositoryEloquent($MedicineHistory);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $records = $this->repository->all('name');
        return ApiResponse::withOk('Medicine histories list', MedicineHistoryResource::collection($records));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MedicineHistoryCategoryRequest $request)
    {
        $record = $this->repository->store($request->all());
        return ApiResponse::withOk('Medicine histories created', new MedicineHistoryResource($record));
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
        return ApiResponse::withOk('Medicine history found', new MedicineHistoryResource($record));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(MedicineHistoryCategoryRequest $request, $id)
    {
        $record = $this->repository->update($request->all(), $id);
        return ApiResponse::withOk('Medicine history updated', new MedicineHistoryResource($record));
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
        return ApiResponse::withOk('Medicine history deleted');
    }
}
