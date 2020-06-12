<?php

namespace App\Http\Controllers\Setups;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiResponse;
use App\Http\Requests\Setups\NhisGdrgServiceTariffMultipleRequest;
use App\Http\Requests\Setups\NhisGdrgServiceTariffRequest;
use App\Http\Requests\Setups\NhisTariffMappingRequest;
use App\Http\Resources\NhisGdrgServiceTariffResource;
use App\Http\Resources\ServiceCollection;
use App\Models\NhisGdrgServiceTariff;
use App\Models\Service;
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
        $records=$this->repository->all('name');
        return ApiResponse::withOk('Nhis Gdrg Service Tariff list',NhisGdrgServiceTariffResource::collection($records));
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

               foreach($request->nhis_provider_levels as $level){
                   $payload=[
                       'gdrg_code'=>$request->gdrg_code,
                       'gdrg_service_name'=>$request->gdrg_service_name,
                       'major_diagnostic_category_id'=>$request->major_diagnostic_category_id,
                       'age_group_id'=>$request->age_group_id,
                       'status'=>$request->status?:'ACTIVE',
                       'nhis_provider_level_id'=>$level['nhis_provider_level_id'],
                       'tariff'=>$level['tariff']
                   ];
                $service_tariff = $this->repository->store($payload);
                $service_ids[] = $service_tariff->id;
               }

         DB::commit();
        return ApiResponse::withOk('Nhis Gdrg Service Tariffs created',NhisGdrgServiceTariffResource::collection($this->repository->getModel()->whereIn('id',$service_ids)->get()));
      /*  }
       catch(Exception $e){
         return ApiResponse::withException($e);
       } */
   }

   function map(NhisTariffMappingRequest $request){
        DB::beginTransaction();
        $service_ids = [];

      foreach($request->services as $service){
          $this->repository->setModel(new Service);
            $service_ids[] =$service['id'];
          $this->repository->update(['nhis_child_tariff_id'=>$service['nhis_child_tariff_id'], 'nhis_adult_tariff_id'=>$service['nhis_adult_tariff_id']],$service['id']);
      }
        return ApiResponse::withOk('Services mapped successfully!', new ServiceCollection($this->repository->getModel()->whereIn('id',$service_ids)->get()));

     DB::commit();
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
