<?php

namespace App\Http\Controllers\Setups;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiResponse;
use App\Http\Requests\Setups\BillingCycleRequest;
use App\Http\Requests\Setups\BillingSystemRequest;
use App\Http\Resources\GeneralCollection;
use App\Http\Resources\GeneralResource;
use App\Models\BillingSystem;
use App\Repositories\RepositoryEloquent;
use Exception;

class BillingSystemController extends Controller
{
    protected $repository;

    public function __construct(BillingSystem $billingSystem)
    {
        $this->repository= new RepositoryEloquent($billingSystem);
    }
    function index(){
        return ApiResponse::withOk('Billing System list',new GeneralCollection($this->repository->all('name')));
    }
    function show($billingSystem){
        $billingSystem=$this->repository->show($billingSystem);//pass the country
        return $billingSystem?
        ApiResponse::withOk('Billing System Found',new GeneralResource($billingSystem))
        : ApiResponse::withNotFound('Billing System Not Found');
    }
   function store(BillingSystemRequest $billingSystemRequest){
       try{
           $requestData=$billingSystemRequest->all();
           $billingSystem=$this->repository->store($requestData);
           return ApiResponse::withOk('Billing System created',new GeneralResource($billingSystem->refresh()));
       }
       catch(Exception $e){
         return ApiResponse::withException($e);
       }
   }
   function update(BillingSystemRequest $billingSystemRequest,$billingSystem){
       try{
        $billingSystem=$this->repository->update($billingSystemRequest->all(),$billingSystem);
        return ApiResponse::withOk('Billing System updated',new GeneralResource($billingSystem));
       }
       catch(Exception $e){
        return ApiResponse::withException($e);
       }
   }
    public function destroy($id)
    {
        $this->repository->delete($id);
        return ApiResponse::withOk('Billing System successfully');
    }
}
