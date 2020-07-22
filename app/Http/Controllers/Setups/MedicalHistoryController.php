<?php

namespace App\Http\Controllers\Setups;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiResponse;
use App\Http\Requests\Setups\ComplaintTypeRequest;
use App\Http\Requests\Setups\IllnessTypeRequest;
use App\Http\Requests\Setups\MedicalHistoryCategoryRequest;
use App\Http\Resources\MedicalHistoryResource;
use App\Models\MedicalHistory;
use App\Repositories\RepositoryEloquent;

class MedicalHistoryController extends Controller
{
    protected $repository;
    public function __construct(MedicalHistory $medicalHistory)
    {
        $this->repository = new RepositoryEloquent($medicalHistory);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $records = $this->repository->all('name');
        return ApiResponse::withOk('Medical histories list', MedicalHistoryResource::collection($records));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MedicalHistoryCategoryRequest $request)
    {
        $record = $this->repository->store($request->all());
        return ApiResponse::withOk('Medical histories created', new MedicalHistoryResource($record));
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
        return ApiResponse::withOk('Medical history found', new MedicalHistoryResource($record));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(MedicalHistoryCategoryRequest $request, $id)
    {
        $record = $this->repository->update($request->all(), $id);
        return ApiResponse::withOk('Medical history updated', new MedicalHistoryResource($record));
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
        return ApiResponse::withOk('Medical history deleted');
    }
}
