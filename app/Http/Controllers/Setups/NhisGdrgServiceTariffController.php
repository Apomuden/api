<?php

namespace App\Http\Controllers\Setups;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiResponse;
use App\Http\Requests\Setups\NhisGdrgServiceTariffMultipleRequest;
use App\Http\Requests\Setups\NhisGdrgServiceTariffRequest;
use App\Http\Resources\NhisGdrgServiceTariffResource;
use App\Models\NhisGdrgServiceTariff;
use App\Repositories\RepositoryEloquent;
use Exception;
use Illuminate\Support\Facades\DB;

class NhisGdrgServiceTariffController extends Controller
{
    protected $repository;

    public function __construct(NhisGdrgServiceTariff $nhisGdrgServiceTariff)
    {
        $this->repository= new RepositoryEloquent($nhisGdrgServiceTariff);
    }

    function index(){

        return ApiResponse::withOk('Nhis Gdrg Service Tariff list',NhisGdrgServiceTariffResource::collection($this->repository->all('name')));
    }

    function show($id){
        $nhisGdrgServiceTariff=$this->repository->show($id);//pass the country
        return $nhisGdrgServiceTariff?
        ApiResponse::withOk('Nhis Gdrg Service Tariff Found',new NhisGdrgServiceTariffResource($nhisGdrgServiceTariff))
        : ApiResponse::withNotFound('Nhis Gdrg Service Tariff Found');
    }

   function store(NhisGdrgServiceTariffRequest $request){
       //try{
           $payload= $request->all();

           $nhisGdrgServiceTariff=$this->repository->store($payload);
        return ApiResponse::withOk('Nhis Gdrg Service Tariff created',new NhisGdrgServiceTariffResource($nhisGdrgServiceTariff->refresh()));
      /*  }
       catch(Exception $e){
         return ApiResponse::withException($e);
       } */
   }
   function storeMultiple(NhisGdrgServiceTariffMultipleRequest $request){
       $service_ids=[];
       DB::beginTransaction();
       //try{
           foreach($request->services as $service)
           {
               $payload=(array)$service;
               $service_tariff=$this->repository->store($payload);
               $service_ids[]=$service_tariff->id;
           }
         DB::commit();
        return ApiResponse::withOk('Nhis Gdrg Service Tariffs created',NhisGdrgServiceTariffResource::collection($this->repository->getModel()->whereIn('id',$service_ids)->get()));
      /*  }
       catch(Exception $e){
         return ApiResponse::withException($e);
       } */
   }

   function update(NhisGdrgServiceTariffRequest $request,$id){
       try{
        $nhisGdrgServiceTariff=$this->repository->update($request->all(),$id);

        return ApiResponse::withOk('Nhis Gdrg Service Tariff updated',new NhisGdrgServiceTariffResource($nhisGdrgServiceTariff));

      }
       catch(Exception $e){
        return ApiResponse::withException($e);
       }
   }
    public function destroy($id)
    {
        $this->repository->delete($id);
        return ApiResponse::withOk('Nhis Gdrg Service Tariff deleted successfully');
    }
}
