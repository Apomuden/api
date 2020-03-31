<?php

namespace App\Http\Controllers\Setups;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiResponse;
use App\Http\Requests\Setups\EducationalLevelRequest;
use App\Http\Resources\GeneralCollection;
use App\Http\Resources\GeneralResource;
use App\Http\Resources\EducationalLevelCollection;
use App\Http\Resources\EducationalLevelResource;
use App\Models\EducationalLevel;

use App\Repositories\RepositoryEloquent;
use Exception;
use Illuminate\Http\Request;

class EducationalLevelController extends Controller
{
    protected $repository;

    public function __construct(EducationalLevel $EducationalLevel)
    {
        $this->repository= new RepositoryEloquent($EducationalLevel);
    }

    function index(){

        return ApiResponse::withOk('EducationalLevel list',new GeneralCollection($this->repository->all('name')));
    }

    function show($EducationalLevel){
        $EducationalLevel=$this->repository->show($EducationalLevel);//pass the country
        return $EducationalLevel?
        ApiResponse::withOk('EducationalLevel Found',new GeneralResource($EducationalLevel))
        : ApiResponse::withNotFound('EducationalLevel Not Found');
    }

   function store(EducationalLevelRequest $EducationalLevelRequest){
       try{
           $requestData=$EducationalLevelRequest->all();

          $EducationalLevel=$this->repository->store($requestData);
        return ApiResponse::withOk('EducationalLevel created',new GeneralResource($EducationalLevel->refresh()));
       }
       catch(Exception $e){
         return ApiResponse::withException($e);
       }
   }

   function update(EducationalLevelRequest $EducationalLevelRequest,$EducationalLevel){
       try{
        $EducationalLevel=$this->repository->update($EducationalLevelRequest->all(),$EducationalLevel);

        return ApiResponse::withOk('EducationalLevel updated',new GeneralResource($EducationalLevel));

       }
       catch(Exception $e){
        return ApiResponse::withException($e);
       }
   }
    public function destroy($id)
    {
        $this->repository->delete($id);
        return ApiResponse::withOk('Educational deleted successfully');
    }
}
