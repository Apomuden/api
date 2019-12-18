<?php

namespace App\Http\Controllers\Setups;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiResponse;
use App\Http\Requests\Setups\AgeGroupRequest;
use App\Http\Requests\Setups\BankBranchRequest;
use App\Http\Requests\Setups\BankRequest;
use App\Http\Resources\AgeGroupCollection;
use App\Http\Resources\AgeGroupResource;
use App\Http\Resources\BankBranchCollection;
use App\Http\Resources\BankBranchResource;
use App\Http\Resources\BankCollection;
use App\Http\Resources\BankResource;
use App\Models\AgeGroup;
use App\Models\Bank;
use App\Models\BankBranch;
use App\Repositories\RepositoryEloquent;
use Exception;
use Illuminate\Http\Request;

class BankBranchController extends Controller
{
    protected $repository;

    public function __construct(BankBranch $bankBranch)
    {
        $this->repository= new RepositoryEloquent($bankBranch);
    }

    function index(){

        return ApiResponse::withOk('Bank Branch list',new BankBranchCollection($this->repository->all('name')));
    }

    function show($bankBranch){
        $bankBranch=$this->repository->show($bankBranch);//pass the country
        return $bankBranch?
        ApiResponse::withOk('Bank Branch Found',new BankBranchResource($bankBranch))
        : ApiResponse::withNotFound('Bank Branch Not Found');
    }

   function store(BankBranchRequest $bankBranchRequest){
       //try{
           $requestData=$bankBranchRequest->all();

           $bankBranch=$this->repository->store($requestData);
        return ApiResponse::withOk('Bank Branch created',new BankBranchResource($bankBranch->refresh()));
      /*  }
       catch(Exception $e){
         return ApiResponse::withException($e);
       } */
   }

   function update(BankBranchRequest $bankRequest,$bankBranch){
       try{
        $bankBranch=$this->repository->update($bankRequest->all(),$bankBranch);

        return ApiResponse::withOk('Bank Branch updated',new BankBranchResource($bankBranch));

      }
       catch(Exception $e){
        return ApiResponse::withException($e);
       }
   }

   function showByBank($bank){
       try{
        $this->repository->setModel(new Bank);
        $bankBranches=$this->repository->findOrFail($bank)->branches()->active()->orderBy('name')->get();
        return $bankBranches?
          ApiResponse::withOk('Available Bank Branches',new BankBranchCollection($bankBranches))
          : ApiResponse::withNotFound('Not Bank Branches Found');
       }
       catch(Exception $e){
        return ApiResponse::withException($e);
       }

   }
}
