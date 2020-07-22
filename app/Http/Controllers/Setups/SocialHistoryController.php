<?php

namespace App\Http\Controllers\Setups;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiResponse;
use App\Http\Requests\Setups\SocialHistoryRequest;
use App\Http\Resources\SocialHistoryResource;
use App\Models\SocialHistory;
use App\Repositories\RepositoryEloquent;

class SocialHistoryController extends Controller
{
    protected $repository;
    public function __construct(SocialHistory $socialHistory)
    {
        $this->repository = new RepositoryEloquent($socialHistory);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $records = $this->repository->all('name');
        return ApiResponse::withOk('Social histories list', SocialHistoryResource::collection($records));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SocialHistoryRequest $request)
    {
        $record = $this->repository->store($request->all());
        return ApiResponse::withOk('Social history created', new SocialHistoryResource($record));
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
        return ApiResponse::withOk('Social history found', new SocialHistoryResource($record));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SocialHistoryRequest $request, $id)
    {
        $record = $this->repository->update($request->all(), $id);
        return ApiResponse::withOk('Social history updated', new SocialHistoryResource($record));
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
        return ApiResponse::withOk('Social history deleted');
    }
}
