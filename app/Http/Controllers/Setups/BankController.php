<?php

namespace App\Http\Controllers\Setups;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiResponse;
use App\Http\Requests\Setups\AgeGroupRequest;
use App\Http\Requests\Setups\BankRequest;
use App\Http\Resources\AgeGroupCollection;
use App\Http\Resources\AgeGroupResource;
use App\Http\Resources\BankCollection;
use App\Http\Resources\BankResource;
use App\Models\AgeGroup;
use App\Models\Bank;
use App\Repositories\RepositoryEloquent;
use Exception;
use Illuminate\Http\Request;

class BankController extends Controller
{
    protected $repository;

    public function __construct(Bank $bank)
    {
        $this->repository= new RepositoryEloquent($bank);
    }

    function index(){

        return ApiResponse::withOk('Banks list',new BankCollection($this->repository->all('name')));
    }

    function show($bank){
        $bank=$this->repository->show($bank);//pass the country
        return $bank?
        ApiResponse::withOk('Bank Found',new BankResource($bank))
        : ApiResponse::withNotFound('Bank Not Found');
    }

   function store(BankRequest $bankRequest){
       //try{
           $requestData=$bankRequest->all();

           $bank=$this->repository->store($requestData);
        return ApiResponse::withOk('Bank created',new BankResource($bank->refresh()));
      /*  }
       catch(Exception $e){
         return ApiResponse::withException($e);
       } */
   }

   function update(BankRequest $bankRequest,$bank){
       try{
        $bank=$this->repository->update($bankRequest->all(),$bank);

        return ApiResponse::withOk('Bank updated',new BankResource($bank));

      }
       catch(Exception $e){
        return ApiResponse::withException($e);
       }
   }
    public function destroy($id)
    {
        $this->repository->delete($id);
        return ApiResponse::withOk('Bank deleted successfully');
    }
}
