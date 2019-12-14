<?php

namespace App\Http\Controllers\Setups;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiResponse;
use App\Http\Resources\RegionCollection;
use App\Http\Resources\RegionResource;
use App\Models\Country;
use App\Models\Region;
use App\Repositories\RegionEloquent;
use Illuminate\Http\Request;

class RegionController extends Controller
{
    protected $repository;

    public function __construct(Region $region)
    {
        $this->repository= new RegionEloquent($region);
    }

    function index(){
        return ApiResponse::withOk('Region list',new RegionCollection($this->repository->all()));
    }

    function show($region){
        $region=$this->repository->show($region);//pass the country
        return $region?
        ApiResponse::withOk('Region Found',new RegionResource($region))
        : ApiResponse::withNotFound('Region Not Found');
    }

   function showByCountry($country){
       $this->repository->setModel(new Country());
       $regions=$this->repository->find($country)->regions()->active()->orderBy('region_name')->get();

       return $regions?
       ApiResponse::withOk('Available Regions',new RegionCollection($regions))
       : ApiResponse::withNotFound('Region Not Found');
   }
}
