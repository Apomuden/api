<?php

namespace App\Http\Controllers\Registration;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiResponse;
use App\Http\Requests\Registrations\DiagnosisMultipleRequest;
use App\Http\Requests\Registrations\DiagnosisRequest;
use App\Http\Resources\Registrations\DiagnosisResource;
use App\Models\Diagnosis;
use App\Repositories\RepositoryEloquent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DiagnosisController extends Controller
{
    protected $repository;
    public function __construct(Diagnosis $diagnosis)
    {
        $this->repository = new RepositoryEloquent($diagnosis);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $records = $this->repository->all('created_at');
        return ApiResponse::withOk('Diagnoses list', DiagnosisResource::collection($records));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DiagnosisRequest $request)
    {
        $record = $this->repository->store($request->all());
        return ApiResponse::withOk('Diagnosis created', new DiagnosisResource($record));
    }

    public function storeMultiple(DiagnosisMultipleRequest $request)
    {
        DB::beginTransaction();
        $diagnoses = $request->diagnoses;
        $diagnoses_ids = [];
        foreach ($diagnoses as $diagnose) {
            $record = $this->repository->store($request->except('diagnoses') + (array) $diagnose);
            $diagnoses_ids[] = $record->id;
        }

        DB::commit();
        $records = $this->repository->getModel()->whereIn('id', $diagnoses_ids)->get();
        return ApiResponse::withOk('Diagnoses created', DiagnosisResource::collection($records));
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
        return ApiResponse::withOk('Diagnosis found', new DiagnosisResource($record));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(DiagnosisRequest $request, $id)
    {
        $record = $this->repository->update($request->all(), $id);
        return ApiResponse::withOk('Diagnosis updated', new DiagnosisResource($record));
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
        return ApiResponse::withOk('Diagnosis deleted');
    }
}
