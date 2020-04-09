<?php

namespace App\Http\Controllers\Setups;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiResponse;
use App\Http\Requests\Setups\DiseaseRequest;
use App\Http\Resources\DiseaseResource;
use App\Models\Disease;
use App\Repositories\RepositoryEloquent;
use Illuminate\Http\Request;

class DiseaseController extends Controller
{
    protected $repository;
    public function __construct(Disease $disease)
    {
        $this->repository = new RepositoryEloquent($disease);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $records = $this->repository->all('name');
        return ApiResponse::withOk('Disease list', DiseaseResource::collection($records));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DiseaseRequest $request)
    {
        $record=$this->repository->store($request->all());
        return ApiResponse::withOk('Disease created',new DiseaseResource($record->refresh()));
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
        return ApiResponse::withOk('Disease found', new DiseaseResource($record));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(DiseaseRequest $request, $id)
    {
        $record = $this->repository->update($request->all(),$id);
        return ApiResponse::withOk('Disease updated', new DiseaseResource($record));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $record = $this->repository->delete($id);
        return ApiResponse::withOk('Disease deleted', new DiseaseResource($record));
    }
}
