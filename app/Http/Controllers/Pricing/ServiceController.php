<?php

namespace App\Http\Controllers\Pricing;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiResponse;
use App\Http\Requests\Pricing\ServiceRequest;
use App\Http\Resources\ServiceCollection;
use App\Http\Resources\ServiceResource;
use App\Models\Service;
use App\Repositories\RepositoryEloquent;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    protected $repository;

    public function __construct(Service $service){
          $this->repository=new RepositoryEloquent($service);
    }
    public function index()
    {
       $services=$this->repository->all('description');

       return ApiResponse::withOk('Service List',new ServiceCollection($services));
    }

    /* public function search(){
       $params=request()->query();
       $servicePrices=$this->repository->getModel()->findBy($params)->orderBy('description')->get();
       return ApiResponse::withOk('Service Prices List',new ServicePriceCollection($servicePrices));
    } */

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ServiceRequest $request)
    {
       $servicePrice=$this->repository->store($request->all());
       return ApiResponse::withOk('Service created',new ServiceResource($servicePrice->refresh()));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($serviceprice)
    {
        $servicePrice=$this->repository->find($serviceprice);
        return ApiResponse::withOk('Found service',new ServiceResource($servicePrice));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ServiceRequest $request,$serviceprice)
    {
       $servicePrice=$this->repository->update($request->all(),$serviceprice);
       return ApiResponse::withOk('Found service updated',new ServiceResource($servicePrice));
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
        return ApiResponse::withOk('Service deleted successfully');
    }
}
