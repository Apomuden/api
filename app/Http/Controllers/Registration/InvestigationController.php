<?php

namespace App\Http\Controllers\Registration;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiResponse;
use App\Http\Requests\Registrations\InvestigationRequest;
use App\Http\Requests\Registrations\InvestigationMultipleRequest;
use App\Http\Resources\Lab\InvestigationResultHierarchicalResource;
use App\Http\Resources\Registrations\InvestigationResource;
use App\Models\Investigation;
use App\Repositories\RepositoryEloquent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InvestigationController extends Controller
{
    protected $repository;
    public function __construct(Investigation $investigation)
    {
        $this->repository = new RepositoryEloquent($investigation, true, 'lab_test_results');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $records = $this->repository->all('created_at');
        return ApiResponse::withOk('Investigations list', InvestigationResource::collection($records));
    }

    public function hierarchyIndex()
    {
        $records = $this->repository->all('created_at');
        return ApiResponse::withOk('Investigations results list', InvestigationResultHierarchicalResource::collection($records));
    }
    public function hierarchyShow($investigation_id)
    {
        $record = $this->repository->find($investigation_id);
        return ApiResponse::withOk('Investigations results found', new InvestigationResultHierarchicalResource($record));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(InvestigationRequest $request)
    {
        $record = $this->repository->store($request->all());
        return ApiResponse::withOk('Investigation created', new InvestigationResource($record->refresh()));
    }

    public function storeMultiple(InvestigationMultipleRequest $request)
    {
        DB::beginTransaction();
        $Investigations = $request->investigations;
        $Investigations_ids = [];
        foreach ($Investigations as $diagnose) {
            $record = $this->repository->store($request->except('investigations') + (array) $diagnose);
            $Investigations_ids[] = $record->id;
        }

        DB::commit();
        $records = $this->repository->getModel()->whereIn('id', $Investigations_ids)->get();
        return ApiResponse::withOk('Investigations created', InvestigationResource::collection($records));
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
        return ApiResponse::withOk('Investigation found', new InvestigationResource($record));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(InvestigationRequest $request, $id)
    {
        $record = $this->repository->update($request->all(), $id);
        return ApiResponse::withOk('Investigation updated', new InvestigationResource($record));
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
        return ApiResponse::withOk('Investigation deleted');
    }
}
