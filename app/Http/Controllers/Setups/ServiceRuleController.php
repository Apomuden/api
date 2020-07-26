<?php

namespace App\Http\Controllers\Setups;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiResponse;
use App\Http\Requests\Setups\ServiceRuleRequest;
use App\Http\Resources\ServiceRuleResource;
use App\Models\ServiceRule;
use App\Repositories\RepositoryEloquent;

class ServiceRuleController extends Controller
{
    protected $repository;

    public function __construct(ServiceRule $serviceRule)
    {
        $this->repository = new RepositoryEloquent($serviceRule);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return ApiResponse::withOk('Service rules',ServiceRuleResource::collection($this->repository->all('name')));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ServiceRuleRequest $request)
    {
       $record= $this->repository->store($request->all());
       return ApiResponse::withOk('Service rule created',new ServiceRuleResource($record->refresh()));
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
        return ApiResponse::withOk('Service rule found', new ServiceRuleResource($record));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ServiceRuleRequest $request, $id)
    {
        $record = $this->repository->update($request->all(),$id);
        return ApiResponse::withOk('Service rule updated', new ServiceRuleResource($record));
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
        return ApiResponse::withOk('Service rule deleted');
    }
}
