<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiResponse;
use App\Http\Requests\Auth\PermissionRequest;
use App\Http\Requests\Setups\RoleRequest;
use App\Http\Resources\PermissionCollection;
use App\Http\Resources\PermissionResource;
use App\Models\Component;
use App\Models\Permission;
use App\Repositories\RepositoryEloquent;
use Exception;

class PermissionController extends Controller
{
    protected $repository;

    public function __construct(Permission $Permission)
    {
        $this->repository= new RepositoryEloquent($Permission,true,['component']);
    }

    function index(){
        $permissions=$this->repository->paginate(10,'name');
        return ApiResponse::withPaginate(new PermissionCollection($permissions,'Permission list'));
    }

    function show($permission){
        $permission=$this->repository->show($permission);//pass the country
        return $permission?
        ApiResponse::withOk('Permission Found',new PermissionResource($permission))
        : ApiResponse::withNotFound('Permission Not Found');
    }



   function update(PermissionRequest $permissionRequest,$permission){
       try{
          $permission=$this->repository->update($permissionRequest->all(),$permission);
        return ApiResponse::withOk('Permission updated',new PermissionResource($permission));
       }
       catch(Exception $e){
        return ApiResponse::withException($e);
       }
   }

   function showByComponent($component){
       $this->repository->setModel(new Component,['permissions'=>function($query){$query->active()->orderBy('name');}]);
       $permissions=$this->repository->find($component)->permissions;

       return ApiResponse::withOk('Available Permissions',PermissionResource::collection($permissions));

   }
}
