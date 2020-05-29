<?php

namespace App\Http\Controllers\Setups;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiResponse;
use App\Http\Requests\Setups\NhisProviderLevelRequest;
use App\Http\Resources\NhisProviderLevelResource;
use App\Models\NhisProviderLevel;
use App\Repositories\RepositoryEloquent;
use Exception;

class NhisProviderLevelController extends Controller
{
    protected $repository;

    public function __construct(NhisProviderLevel $nhisProviderLevel)
    {
        $this->repository= new RepositoryEloquent($nhisProviderLevel);
    }

    function index(){

        return ApiResponse::withOk('NHIS Provider Level list',NhisProviderLevelResource::collection($this->repository->all('name')));
    }

    function show($NHIS){
        $nhisProviderLevel=$this->repository->show($NHIS);//pass the country
        return $nhisProviderLevel?
        ApiResponse::withOk('NHIS Provider Level Found',new NhisProviderLevelResource($NHIS))
        : ApiResponse::withNotFound('NHIS Provider Level Found');
    }

   function store(NhisProviderLevelRequest $NHISRequest){
       //try{
           $requestData=$NHISRequest->all();

           $nhisProviderLevel=$this->repository->store($requestData);
        return ApiResponse::withOk('NHIS provider level created',new NhisProviderLevelResource($nhisProviderLevel->refresh()));
      /*  }
       catch(Exception $e){
         return ApiResponse::withException($e);
       } */
   }

   function update(NhisProviderLevelRequest $NHISRequest,$id){
       try{
        $nhisProviderLevel=$this->repository->update($NHISRequest->all(),$id);

        return ApiResponse::withOk('NHIS provider level updated',new NhisProviderLevelResource($nhisProviderLevel));

      }
       catch(Exception $e){
        return ApiResponse::withException($e);
       }
   }
    public function destroy($id)
    {
        $this->repository->delete($id);
        return ApiResponse::withOk('NHIS provider level deleted successfully');
    }
}
