<?php

namespace App\Http\Controllers\Setups;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiResponse;
use App\Http\Requests\Setups\CompanyRequest;
use App\Http\Resources\CompanyCollection;
use App\Http\Resources\CompanyResource;
use App\Models\Company;
use App\Repositories\RepositoryEloquent;
use Exception;

class CompanyController extends Controller
{
    protected $repository;

    public function __construct(Company $company)
    {
        $this->repository= new RepositoryEloquent($company);
    }

    function index(){

        return ApiResponse::withOk('Company list',new CompanyCollection($this->repository->all('name')));
    }

    function show($company){
        $company=$this->repository->show($company);//pass the country
        return $company?
        ApiResponse::withOk('Company Found',new CompanyResource($company))
        : ApiResponse::withNotFound('Company Not Found');
    }

   function store(CompanyRequest $companyRequest){
       try{
           $requestData=$companyRequest->all();

           $company=$this->repository->store($requestData);
          return ApiResponse::withOk('Company created',new CompanyResource($company->refresh()));
      }
       catch(Exception $e){
         return ApiResponse::withException($e);
       }
   }

   function update(CompanyRequest $companyRequest,$company){
       try{
        $company=$this->repository->update($companyRequest->all(),$company);

        return ApiResponse::withOk('Company updated',new CompanyResource($company));

      }
       catch(Exception $e){
        return ApiResponse::withException($e);
       }
   }

}
