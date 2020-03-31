<?php

namespace App\Http\Controllers\Setups;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiResponse;
use App\Http\Requests\Setups\DistrictRequest;
use App\Http\Resources\DistrictCollection;
use App\Http\Resources\DistrictResource;
use App\Models\Country;
use App\Models\District;
use App\Models\Region;
use App\Repositories\RepositoryEloquent;
use Exception;
use Illuminate\Http\Request;

class DistrictController extends Controller
{
    protected $repository;

    public function __construct(District $district)
    {
        $this->repository= new RepositoryEloquent($district);
    }

    function index(){
        return ApiResponse::withOk('District list',new DistrictCollection($this->repository->all()));
    }

    function show($district){
        $district=$this->repository->show($district);//pass the country
        return $district?
        ApiResponse::withOk('District Found',new DistrictResource($district))
        : ApiResponse::withNotFound('District Not Found');
    }

   function store(DistrictRequest $districtRequest){
       try{
           $requestData=$districtRequest->all();
           $requestData['country_id']=Region::findorFail($requestData['region_id'])->country_id;

          $district=$this->repository->store($requestData);
        return ApiResponse::withOk('District created',new DistrictResource($district->refresh()));
       }
       catch(Exception $e){
         return ApiResponse::withException($e);
       }
   }

   function update(DistrictRequest $districtRequest,$district){
       try{
        $district=$this->repository->update($districtRequest->all(),$district);

        return ApiResponse::withOk('District updated',new DistrictResource($district));

       }
       catch(Exception $e){
        return ApiResponse::withException($e);
       }
   }
    public function destroy($id)
    {
        $this->repository->delete($id);
        return ApiResponse::withOk('District deleted successfully');
    }
   function showByRegion($region){
       try{
        $this->repository->setModel(new Region());
        $districts=$this->repository->find($region)->districts()->active()->orderBy('name')->get();

        return $districts?
        ApiResponse::withOk('Available districts',new DistrictCollection($districts)):
        ApiResponse::withNotFound('District Not Found');
       }
       catch(Exception $e){
        return ApiResponse::withException($e);
       }


   }
}
