<?php

namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\AttachModulesToRoleRequest;
use App\Models\Role;
use App\Repositories\RepositoryEloquent;
use Illuminate\Http\Request;
use App\Http\Helpers\ApiResponse;
use App\Http\Requests\Auth\AttachComponentsRequest;
use App\Http\Requests\Auth\AttachModulesToUserRequest;
use App\Http\Requests\Auth\AttachPermissionsRequest;
use App\Http\Requests\Auth\DetachComponentsRequest;
use App\Http\Requests\Auth\DetachModulesToRoleRequest;
use App\Http\Requests\Auth\DetachModulesToUserRequest;
use App\Models\User;
use Exception;

class AuthorizationController extends Controller
{
    protected $repository;

    public function __construct(Role $role)
    {
        $this->repository= new RepositoryEloquent($role);
    }

    function attachModulesToRole(AttachModulesToRoleRequest $request,$role){
        try{
            $role=$this->repository->findOrFail($role);

            $role->syncModules($request->modules);

            return ApiResponse::withOk('Modules attached to role successfully');
        }
        catch(Exception $e){
            return ApiResponse::withException($e);
        }
    }

    function detachModulesFromRole(DetachModulesToRoleRequest $request,$role,$cascade=false){
        try{
            $role=$this->repository->findOrFail($role);

            $role->detachModules($request->modules,$cascade);

            return ApiResponse::withOk('Modules detached from role successfully');
        }
        catch(Exception $e){
            return ApiResponse::withException($e);
        }
    }
    function attachComponentsToRole(AttachComponentsRequest $request,$role){
        try{
            $role=$this->repository->findOrFail($role);
            $role->syncComponents($request->components);
            return ApiResponse::withOk('Components attached to role successfully');
        }
        catch(Exception $e){
            return ApiResponse::withException($e);
        }
    }
    function detachComponentsFromRole(DetachComponentsRequest $request,$role,$cascade=false){
        try{
            $role=$this->repository->findOrFail($role);

            $role->detachComponents($request->components,$cascade);

            return ApiResponse::withOk('Components detached from role successfully');
        }
        catch(Exception $e){
            return ApiResponse::withException($e);
        }
    }
    function detachComponentsFromRoleCascade(DetachComponentsRequest $request,$role){
        return $this->detachComponentsFromRole($request,$role,true);
    }


    function detachModulesFromRoleCascade(DetachModulesToRoleRequest $request,$role){
        return $this->detachModulesFromRole($request,$role,true);
    }

    function attachModulesToUser(AttachModulesToUserRequest $request,$user){
        try{
            $this->repository->setModel(new User);
            $user=$this->repository->findOrFail($user);
            $user->syncModules($request->modules);

            return ApiResponse::withOk('Modules attached to user successfully');
        }
        catch(Exception $e){
            return ApiResponse::withException($e);
        }
    }
    function detachModulesFromUser(DetachModulesToUserRequest $request,$user){
        try{
            $this->repository->setModel(new User);
            $user=$this->repository->findOrFail($user);
            $user->detachModules($request->modules);

            return ApiResponse::withOk('Modules detached from user successfully');
        }
        catch(Exception $e){
            return ApiResponse::withException($e);
        }
    }


    function attachComponentsToUser(AttachComponentsRequest $request,$user){
        try{
            $this->repository->setModel(new User);
            $user=$this->repository->findOrFail($user);
            $user->syncComponents($request->components);
            return ApiResponse::withOk('Components attached to user successfully');
        }
        catch(Exception $e){
            return ApiResponse::withException($e);
        }
    }
    function detachComponentsFromUser(DetachComponentsRequest $request,$user){
        try{
            $this->repository->setModel(new User);
            $user=$this->repository->findOrFail($user);
            $user->detachComponents($request->components);
            return ApiResponse::withOk('Components detached from user successfully');
        }
        catch(Exception $e){
            return ApiResponse::withException($e);
        }
    }
}
