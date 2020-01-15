<?php

namespace App\Http\Controllers\Setups;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiResponse;
use App\Http\Requests\Setups\SpecialtyRequest;
use App\Http\Resources\GeneralCollection;
use App\Http\Resources\GeneralResource;
use App\Models\StaffSpecialty;
use App\Repositories\RepositoryEloquent;
use Exception;
use Illuminate\Http\Request;

class SpecialtyController extends Controller
{
    protected $repository;

    public function __construct(StaffSpecialty $specialty)
    {
        $this->repository=new RepositoryEloquent($specialty);
    }

    function index(){
        return ApiResponse::withOk('Specialty list',new GeneralCollection($this->repository->all('name')));
    }

    function show($specialty){
        $specialty=$this->repository->show($specialty);//pass the country
        return $specialty?
        ApiResponse::withOk('Specialty Found',new GeneralResource($specialty))
        : ApiResponse::withNotFound('Specialty Not Found');
    }

   function store(SpecialtyRequest $SpecialtyRequest){
       try{
           $requestData=$SpecialtyRequest->all();
           $specialty=$this->repository->store($requestData);
           return ApiResponse::withOk('Specialty created',new GeneralResource($specialty->refresh()));
       }
       catch(Exception $e){
         return ApiResponse::withException($e);
       }
   }

   function update(SpecialtyRequest $SpecialtyRequest,$specialty){
       try{
        $specialty=$this->repository->update($SpecialtyRequest->all(),$specialty);
        return ApiResponse::withOk('Specialty updated',new GeneralResource($specialty));
       }
       catch(Exception $e){
        return ApiResponse::withException($e);
       }
   }
    public function destroy($id)
    {
        $this->repository->delete($id);
        return ApiResponse::withOk('Specialty deleted successfully');
    }
}
