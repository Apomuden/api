<?php

namespace App\Http\Controllers\Setups;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiResponse;
use App\Http\Requests\Setups\DepartmentRequest;
use App\Http\Resources\DepartmentCollection;
use App\Http\Resources\DepartmentResource;
use App\Models\Department;

use App\Repositories\RepositoryEloquent;
use Exception;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    protected $repository;

    public function __construct(Department $Department)
    {
        $this->repository= new RepositoryEloquent($Department);
    }

    function index(){

        return ApiResponse::withOk('Department list',new DepartmentCollection($this->repository->all('name')));
    }

    function show($Department){
        $Department=$this->repository->show($Department);//pass the country
        return $Department?
        ApiResponse::withOk('Department Found',new DepartmentResource($Department))
        : ApiResponse::withNotFound('Department Not Found');
    }

   function store(DepartmentRequest $DepartmentRequest){
       try{
           $requestData=$DepartmentRequest->all();

           $Department=$this->repository->store($requestData);
        return ApiResponse::withOk('Department created',new DepartmentResource($Department->refresh()));
       }
       catch(Exception $e){
         return ApiResponse::withException($e);
       }
   }

   function update(DepartmentRequest $DepartmentRequest,$Department){
       try{
        $Department=$this->repository->update($DepartmentRequest->all(),$Department);

        return ApiResponse::withOk('Department updated',new DepartmentResource($Department));

       }
       catch(Exception $e){
        return ApiResponse::withException($e);
       }
   }

}
