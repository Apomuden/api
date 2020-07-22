<?php

namespace App\Http\Controllers\Setups;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiResponse;
use App\Http\Requests\Setups\IllnessTypeRequest;
use App\Http\Resources\IllnessTypeResource;
use App\Models\IllnessType;
use App\Repositories\RepositoryEloquent;
use Illuminate\Http\Request;

class IllnessTypeController extends Controller
{
    protected $repository;
    public function __construct(IllnessType $illnessType)
    {
        $this->repository = new RepositoryEloquent($illnessType);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $records = $this->repository->all('name');
        return ApiResponse::withOk('Illness types list', IllnessTypeResource::collection($records));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(IllnessTypeRequest $request)
    {
        $record = $this->repository->store($request->all());
        return ApiResponse::withOk('Illness type created', new IllnessTypeResource($record));
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
        return ApiResponse::withOk('Illness type found', new IllnessTypeResource($record));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(IllnessTypeRequest $request, $id)
    {
        $record = $this->repository->update($request->all(), $id);
        return ApiResponse::withOk('Illness type updated', new IllnessTypeResource($record));
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
        return ApiResponse::withOk('Illness type deleted');
    }
}
