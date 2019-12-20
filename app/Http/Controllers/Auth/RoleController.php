<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiResponse;
use App\Http\Requests\Setups\RoleRequest;
use App\Http\Resources\RoleCollection;
use App\Http\Resources\RoleResource;
use App\Models\Role;
use App\Repositories\RepositoryEloquent;
use Exception;

class RoleController extends Controller
{
    protected $repository;

    public function __construct(Role $role)
    {
        $this->repository= new RepositoryEloquent($role);
    }

    function index(){
        return ApiResponse::withOk('Role list',new RoleCollection($this->repository->all('name')));
    }

    function show($role){
        $role=$this->repository->show($role);//pass the country
        return $role?
        ApiResponse::withOk('Role Found',new RoleResource($role))
        : ApiResponse::withNotFound('Role Not Found');
    }

   function store(RoleRequest $roleRequest){
       try{
           $requestData=$roleRequest->all();
           $role=$this->repository->store($requestData);
           return ApiResponse::withOk('Role created',new RoleResource($role->refresh()));
       }
       catch(Exception $e){
         return ApiResponse::withException($e);
       }
   }

   function update(RoleRequest $roleRequest,$role){
       try{
          $role=$this->repository->update($roleRequest->all(),$role);
        return ApiResponse::withOk('Role updated',new RoleResource($role));
       }
       catch(Exception $e){
        return ApiResponse::withException($e);
       }
   }
}
