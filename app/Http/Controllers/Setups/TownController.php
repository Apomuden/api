<?php

namespace App\Http\Controllers\Setups;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiResponse;
use App\Http\Requests\Setups\DistrictRequest;
use App\Http\Requests\Setups\TownRequest;
use App\Http\Resources\DistrictCollection;
use App\Http\Resources\DistrictResource;
use App\Http\Resources\TownCollection;
use App\Http\Resources\TownResource;
use App\Models\District;
use App\Models\Town;
use App\Repositories\RepositoryEloquent;
use Exception;
use Illuminate\Http\Request;

class TownController extends Controller
{
    protected $repository;

    public function __construct(Town $town)
    {
        $this->repository= new RepositoryEloquent($town);
    }

    function index(){
        return ApiResponse::withOk('Towns list',new TownCollection($this->repository->all()));
    }

    function show($district){
        $district=$this->repository->show($district);//pass the country
        return $district?
        ApiResponse::withOk('Town Found',new TownResource($district))
        : ApiResponse::withNotFound('Town Not Found');
    }

   function store(TownRequest $townRequest){
       try{
           $requestData=$townRequest->all();
           $district=District::findorFail($requestData['district_id']);
           $requestData['country_id']=$district->country_id;
           $requestData['region_id']=$district->region_id;

          $district=$this->repository->store($requestData);
        return ApiResponse::withOk('Town created',new DistrictResource($district->refresh()));
       }
       catch(Exception $e){
         return ApiResponse::withException($e);
       }
   }

   function update(TownRequest $townRequest,$district){
       try{
        $district=$this->repository->update($townRequest->all(),$district);

        return ApiResponse::withOk('Town updated',new DistrictResource($district));

       }
       catch(Exception $e){
        return ApiResponse::withException($e);
       }
   }
    public function destroy($id)
    {
        $this->repository->delete($id);
        return ApiResponse::withOk('Town deleted successfully');
    }
   function showByDistrict($district){
     $this->repository->setModel(new District);
     $towns=$this->repository->find($district)->towns()->active()->orderBy('name')->get();

     return $towns?
     ApiResponse::withOk('Available Towns',new TownCollection($towns))
     : ApiResponse::withNotFound('Towns Not Found');
   }
}
