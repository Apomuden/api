<?php

namespace App\Http\Controllers\Registration;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiResponse;
use App\Http\Requests\Registrations\ProcedureRequest;
use App\Http\Requests\Registrations\ProcedureMultipleRequest;
use App\Http\Resources\Registrations\ProcedureResource;
use App\Models\Procedure;
use App\Repositories\RepositoryEloquent;
use Illuminate\Support\Facades\DB;

class ProcedureController extends Controller
{
    protected $repository;
    public function __construct(Procedure $procedure)
    {
        $this->repository = new RepositoryEloquent($procedure);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $records = $this->repository->all('created_at');
        return ApiResponse::withOk('Procedures list', ProcedureResource::collection($records));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProcedureRequest $request)
    {
        $record = $this->repository->store($request->all());
        return ApiResponse::withOk('Procedure created', new ProcedureResource($record->refresh()));
    }

    public function storeMultiple(ProcedureMultipleRequest $request)
    {
        DB::beginTransaction();
        $Procedures = $request->Procedures;
        $Procedures_ids = [];
        foreach ($Procedures as $diagnose) {
            $record = $this->repository->store($request->except('Procedures') + (array) $diagnose);
            $Procedures_ids[] = $record->id;
        }

        DB::commit();
        $records = $this->repository->getModel()->whereIn('id', $Procedures_ids)->get();
        return ApiResponse::withOk('Procedures created', ProcedureResource::collection($records));
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
        return ApiResponse::withOk('Procedure found', new ProcedureResource($record));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProcedureRequest $request, $id)
    {
        $record = $this->repository->update($request->all(), $id);
        return ApiResponse::withOk('Procedure updated', new ProcedureResource($record));
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
        return ApiResponse::withOk('Procedure deleted');
    }
}
