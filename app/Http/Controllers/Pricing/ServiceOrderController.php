<?php

namespace App\Http\Controllers\Pricing;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiResponse;
use App\Http\Requests\Pricing\ServiceOrderRequest;
use App\Http\Resources\Clinic\ServiceOrderResource;
use App\Models\ServiceOrder;
use App\Repositories\RepositoryEloquent;
use Illuminate\Http\Request;

class ServiceOrderController extends Controller
{
    protected $repository;

    public function __construct(ServiceOrder $serviceOrder)
    {
        $this->repository = new RepositoryEloquent($serviceOrder);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $records = $this->repository->all('id');

        return ApiResponse::withOk('Service Order List', ServiceOrderResource::collection($records));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ServiceOrderRequest $request)
    {
        $record=$this->repository->store($request->all());
        return ApiResponse::withOk('Service Order',new ServiceOrderResource($record->refresh()));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $record=$this->repository->findOrFail($id);
        return ApiResponse::withOk('Service Order found', new ServiceOrderResource($record));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ServiceOrderRequest $request, $id)
    {
        $record=$this->repository->update($request->all(),$id);
        return ApiResponse::withOk('Service Order updated', new ServiceOrderResource($record));
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
        return ApiResponse::withOk('Service Order deleted successfully!');
    }
}
