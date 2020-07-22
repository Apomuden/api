<?php

namespace App\Http\Controllers\Registration;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiResponse;
use App\Http\Requests\Clinic\DeliveryNoteRequest;
use App\Http\Resources\Clinic\DeliveryNoteResource;
use App\Models\DeliveryNote;
use App\Repositories\RepositoryEloquent;

class DeliveryNoteController extends Controller
{
    protected $repository;
    public function __construct(DeliveryNote $deliveryNote)
    {
        $this->repository = new RepositoryEloquent($deliveryNote);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return ApiResponse::withOk('Delivery notes list', DeliveryNoteResource::collection($this->repository->all('created_at')));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DeliveryNoteRequest $request)
    {
        $record = $this->repository->store($request->all());
        return ApiResponse::withOk('Delivery note created', new DeliveryNoteResource($record->refresh()));
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
        return ApiResponse::withOk('Delivery note found', new DeliveryNoteResource($record));
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(DeliveryNoteRequest $request, $id)
    {
        $record = $this->repository->update($request->all(), $id);
        return ApiResponse::withOk('Delivery note updated', new DeliveryNoteResource($record));
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
        return ApiResponse::withOk('Delivery note deleted');
    }
}
