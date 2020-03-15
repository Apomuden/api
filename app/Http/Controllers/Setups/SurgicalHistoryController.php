<?php

namespace App\Http\Controllers\Setups;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiResponse;
use App\Http\Requests\Setups\SurgicalHistoryRequest;
use App\Http\Resources\SurgicalHistoryResource;
use App\Models\SurgicalHistory;
use App\Repositories\RepositoryEloquent;

class MedicalHistoryController extends Controller
{
    protected $repository;
    public function __construct(SurgicalHistory $surgicalHistory)
    {
        $this->repository = new RepositoryEloquent($surgicalHistory);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $records=$this->repository->all('name');
        return ApiResponse::withOk('Surgical histories list',SurgicalHistoryResource::collection($records));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SurgicalHistoryRequest $request)
    {
        $record=$this->repository->store($request->all());
        return ApiResponse::withOk('Surgical history created',new SurgicalHistoryResource($record));
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
        return ApiResponse::withOk('Surgical history found',new SurgicalHistoryResource($record));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SurgicalHistoryRequest $request, $id)
    {
        $record=$this->repository->update($request->all(),$id);
        return ApiResponse::withOk('Surgical history updated', new SurgicalHistoryResource($record));
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
        return ApiResponse::withOk('Surgical history deleted');
    }
}
