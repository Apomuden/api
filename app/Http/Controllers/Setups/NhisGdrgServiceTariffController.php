<?php

namespace App\Http\Controllers\Setups;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiResponse;
use App\Http\Requests\Setups\NhisGdrgServiceTariffMultipleRequest;
use App\Http\Requests\Setups\NhisGdrgServiceTariffRequest;
use App\Http\Requests\Setups\NhisTariffMappingRequest;
use App\Http\Resources\NhisGdrgServiceTariffResource;
use App\Http\Resources\NhisServiceTariffPaginatedCollection;
use App\Http\Resources\ServiceCollection;
use App\Models\NhisAccreditationSetting;
use App\Models\NhisGdrgServiceTariff;
use App\Models\NhisProviderLevelTariff;
use App\Models\Patient;
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

    function page(){
        $records=$this->repository->paginate(null, 'gdrg_service_name');
        return ApiResponse::withPaginate(new NhisServiceTariffPaginatedCollection($records, 'Nhis Gdrg Service Tariff Paginated List'));
    }

    
   function store(NhisGdrgServiceTariffMultipleRequest $request){
       $service_ids=[];
       //DB::beginTransaction();

               $payload=[
                    'gdrg_code' => $request->gdrg_code,
                    'gdrg_service_name' => $request->gdrg_service_name,
                    'major_diagnostic_category_id' => $request->major_diagnostic_category_id,
                    'age_group_id' => $request->age_group_id,
                    'status' => $request->status ?: 'ACTIVE'
               ];
               $service_tariff = $this->repository->store($payload);

         //DB::commit();
        return ApiResponse::withOk('Nhis Gdrg Service Tariffs created',new NhisGdrgServiceTariffResource($this->repository->find($service_tariff->id)));
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
        DB::commit();
        return ApiResponse::withOk('Services mapped successfully!', new ServiceCollection($this->repository->getModel()->whereIn('id',$service_ids)->get()));
   }

   function update(NhisGdrgServiceTariffRequest $request,$id){
       try{
        $nhisGdrgServiceTariff=$this->repository->update($request->only([
                'gdrg_code',
                'gdrg_service_name',
                'major_diagnostic_category_id',
                'age_group_id',
                'status'
        ])+['updated_at'=>now()],$id);

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
