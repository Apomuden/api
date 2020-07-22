<?php

namespace App\Http\Controllers\Registration;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiResponse;
use App\Http\Requests\Clinic\ProgressNoteRequest;
use App\Http\Resources\Clinic\GeneralNoteResource;
use  App\Models\ProgressNote;
use App\Repositories\RepositoryEloquent;

class ProgressNoteController extends Controller
{
    protected $repository;
    public function __construct(ProgressNote $ProgressNote)
    {
        $this->repository = new RepositoryEloquent($ProgressNote);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return ApiResponse::withOk('Progress notes list', GeneralNoteResource::collection($this->repository->all('created_at')));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProgressNoteRequest $request)
    {
        $record = $this->repository->store($request->all());
        return ApiResponse::withOk('Progress note created', new GeneralNoteResource($record->refresh()));
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
        return ApiResponse::withOk('Progress note found', new GeneralNoteResource($record));
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProgressNoteRequest $request, $id)
    {
        $record = $this->repository->update($request->all(), $id);
        return ApiResponse::withOk('Progress note updated', new GeneralNoteResource($record));
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
        return ApiResponse::withOk('Progress note deleted');
    }
}
