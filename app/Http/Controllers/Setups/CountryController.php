<?php

namespace App\Http\Controllers\Setups;
use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiResponse;
use App\Http\Resources\CountryCollection;
use App\Http\Resources\CountryResource;
use App\Models\Country;
use App\Repositories\CountryEloquent;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    protected $repository;

    public function __construct(Country $hospital)
    {
        $this->repository= new CountryEloquent($hospital);
    }

    function index(){
        return ApiResponse::withOk('Countries list',new CountryCollection($this->repository->all()));
    }

    function show($country){
        $country=$this->repository->show($country);//pass the country
        return $country?
        ApiResponse::withOk('Country Found',new CountryResource($country))
        : ApiResponse::withNotFound('Country Not Found');
    }

}
