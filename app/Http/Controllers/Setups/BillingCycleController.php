<?php

namespace App\Http\Controllers\Setups;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiResponse;
use App\Http\Requests\Setups\BillingCycleRequest;
use App\Http\Requests\Setups\StaffTypeRequest;
use App\Http\Resources\GeneralCollection;
use App\Http\Resources\GeneralResource;
use App\Models\BillingCycle;
use App\Repositories\RepositoryEloquent;
use Exception;

class BillingCycleController extends Controller
{
    protected $repository;

    public function __construct(BillingCycle $billingCycle)
    {
        $this->repository= new RepositoryEloquent($billingCycle);
    }
    function index(){
        return ApiResponse::withOk('Billing Cycle list',new GeneralCollection($this->repository->all('name')));
    }
    function show($billingCycle){
        $billingCycle=$this->repository->show($billingCycle);//pass the country
        return $billingCycle?
        ApiResponse::withOk('Billing Cycle Found',new GeneralResource($billingCycle))
        : ApiResponse::withNotFound('Billing Cycle Not Found');
    }
   function store(BillingCycleRequest $billingCycleRequest){
       try{
           $requestData=$billingCycleRequest->all();
           $billingCycle=$this->repository->store($requestData);
           return ApiResponse::withOk('Billing Cycle created',new GeneralResource($billingCycle->refresh()));
       }
       catch(Exception $e){
         return ApiResponse::withException($e);
       }
   }
   function update(BillingCycleRequest $billingCycleRequest,$billingCycle){
       try{
        $billingCycle=$this->repository->update($billingCycleRequest->all(),$billingCycle);
        return ApiResponse::withOk('Billing Cycle updated',new GeneralResource($billingCycle));
       }
       catch(Exception $e){
        return ApiResponse::withException($e);
       }
   }
}
