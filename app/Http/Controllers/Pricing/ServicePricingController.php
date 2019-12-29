<?php

namespace App\Http\Controllers\Pricing;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiResponse;
use App\Http\Requests\Pricing\ServicePriceRequest;
use App\Http\Resources\ServicePriceCollection;
use App\Http\Resources\ServicePriceResource;
use App\Models\ServicePrice;
use App\Repositories\RepositoryEloquent;
use Illuminate\Http\Request;

class ServicePricingController extends Controller
{
    protected $repository;

    public function __construct(ServicePrice $servicePrice){
          $this->repository=new RepositoryEloquent($servicePrice);
    }
    public function index()
    {
       $servicePrices=$this->repository->all('description');

       return ApiResponse::withOk('Service Prices List',new ServicePriceCollection($servicePrices));
    }

    public function search(){
       $params=request()->query();
       $servicePrices=$this->repository->getModel()->findBy($params)->orderBy('description')->get();
       return ApiResponse::withOk('Service Prices List',new ServicePriceCollection($servicePrices));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ServicePriceRequest $request)
    {
       $servicePrice=$this->repository->store($request->all());
       return ApiResponse::withOk('Service price created',new ServicePriceResource($servicePrice->refresh()));
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
        return ApiResponse::withOk('Found service price',new ServicePriceResource($servicePrice));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ServicePriceRequest $request,$serviceprice)
    {
       $servicePrice=$this->repository->update($request->all(),$serviceprice);
       return ApiResponse::withOk('Found service price',new ServicePriceResource($servicePrice));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
