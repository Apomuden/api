<?php

namespace App\Http\Controllers\Setups;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiResponse;
use App\Http\Resources\RegionCollection;
use App\Http\Resources\RegionResource;
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

    function show($country){
        $country=$this->repository->show($country);//pass the country
        return $country?
        ApiResponse::withOk('Region Found',new RegionResource($country))
        : ApiResponse::withNotFound('Region Not Found');
    }
}
