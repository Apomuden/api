<?php

namespace App\Http\Controllers\Setups;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiResponse;
use App\Http\Requests\Setups\AllergyHistoryCategoryRequest;
use App\Http\Requests\Setups\AllergyHistoryRequest;
use App\Http\Resources\AllergyHistoryResource;
use App\Models\AllergyHistory;
use App\Repositories\RepositoryEloquent;

class AllergyHistoryController extends Controller
{
    protected $repository;
    public function __construct(AllergyHistory $AllergyHistory)
    {
        $this->repository = new RepositoryEloquent($AllergyHistory);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $records = $this->repository->all('name');
        return ApiResponse::withOk('Allergy histories list', AllergyHistoryResource::collection($records));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AllergyHistoryRequest $request)
    {
        $record = $this->repository->store($request->all());
        return ApiResponse::withOk('Allergy histories created', new AllergyHistoryResource($record));
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
        return ApiResponse::withOk('Allergy history found', new AllergyHistoryResource($record));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AllergyHistoryRequest $request, $id)
    {
        $record = $this->repository->update($request->all(), $id);
        return ApiResponse::withOk('Allergy history updated', new AllergyHistoryResource($record));
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
        return ApiResponse::withOk('Allergy history deleted');
    }
}
