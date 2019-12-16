<?php

namespace App\Http\Controllers\Setups;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiResponse;
use App\Http\Requests\Setups\DistrictRequest;
use App\Http\Requests\Setups\ReligionRequest;
use App\Http\Requests\Setups\TownRequest;
use App\Http\Resources\DistrictCollection;
use App\Http\Resources\DistrictResource;
use App\Http\Resources\GeneralCollection;
use App\Http\Resources\GeneralResource;
use App\Http\Resources\TownCollection;
use App\Http\Resources\TownResource;
use App\Models\District;
use App\Models\Religion;
use App\Models\Town;
use App\Repositories\RepositoryEloquent;
use Exception;
use Illuminate\Http\Request;

class ReligionController extends Controller
{
    protected $repository;

    public function __construct(Religion $religion)
    {
        $this->repository= new RepositoryEloquent($religion);
    }

    function index(){

        return ApiResponse::withOk('Religions list',new GeneralCollection($this->repository->all('name')));
    }

    function show($religion){
        $religion=$this->repository->show($religion);//pass the country
        return $religion?
        ApiResponse::withOk('Religion Found',new GeneralResource($religion))
        : ApiResponse::withNotFound('Religion Not Found');
    }

   function store(ReligionRequest $religionRequest){
       try{
           $requestData=$religionRequest->all();

          $religion=$this->repository->store($requestData);
        return ApiResponse::withOk('Religion created',new GeneralResource($religion->refresh()));
       }
       catch(Exception $e){
         return ApiResponse::withException($e);
       }
   }

   function update(ReligionRequest $religionRequest,$religion){
       try{
        $religion=$this->repository->update($religionRequest->all(),$religion);

        return ApiResponse::withOk('Religion updated',new GeneralResource($religion));

       }
       catch(Exception $e){
        return ApiResponse::withException($e);
       }
   }


}
