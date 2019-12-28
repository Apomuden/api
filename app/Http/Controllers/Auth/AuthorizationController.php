<?php

namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\AttachModulesToRoleRequest;
use App\Models\Role;
use App\Repositories\RepositoryEloquent;
use Illuminate\Http\Request;
use App\Http\Helpers\ApiResponse;
use App\Http\Requests\Auth\AttachModulesToUserRequest;
use App\Http\Requests\Auth\AttachPermissionsRequest;
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

            $role->attachModules($request->module_ids);

            return ApiResponse::withOk('Modules attached to role successfully');
        }
        catch(Exception $e){
            return ApiResponse::withException($e);
        }
    }

    function detachModulesFromRole(AttachModulesToRoleRequest $request,$role,$cascade){
        try{
            $role=$this->repository->findOrFail($role);

            $role->detachModules($request->module_ids);

            return ApiResponse::withOk('Modules detached from role successfully');
        }
        catch(Exception $e){
            return ApiResponse::withException($e);
        }
    }

    function detachModulesFromRoleCascade(AttachModulesToRoleRequest $request,$role){
        return $this->detachModulesFromRole($request,$role,true);
    }

    function attachPermissionsToRole(AttachPermissionsRequest $request,$role){
        try{
            $role=$this->repository->findOrFail($role);

            $role->attachPermissions($request->permission_ids);

            return ApiResponse::withOk('Permissions attached to role successfully');
        }
        catch(Exception $e){
            return ApiResponse::withException($e);
        }
    }

    function detachPermissionsFromRole(AttachPermissionsRequest $request,$role,$cascade=false){
        try{
            $role=$this->repository->findOrFail($role);

            $role->detachPermissions($request->permission_ids,$cascade);

            return ApiResponse::withOk('Permissions detached from role successfully');
        }
        catch(Exception $e){
            return ApiResponse::withException($e);
        }
    }

    function detachPermissionsFromRoleCascade(AttachPermissionsRequest $request,$role){
       return $this->detachPermissionsFromRole($request,$role,true);
    }

    function attachModulesToUser(AttachModulesToUserRequest $request,$user){
        try{
            $this->repository->setModel(new User);
            $user=$this->repository->findOrFail($user);
            $user->attachModules($request->module_ids);

            return ApiResponse::withOk('Modules attached to user successfully');
        }
        catch(Exception $e){
            return ApiResponse::withException($e);
        }
    }
    function detachModulesFromUser(AttachModulesToUserRequest $request,$user){
        try{
            $this->repository->setModel(new User);
            $user=$this->repository->findOrFail($user);
            $user->detachModules($request->module_ids);

            return ApiResponse::withOk('Modules detached from user successfully');
        }
        catch(Exception $e){
            return ApiResponse::withException($e);
        }
    }
    function attachPermissionsToUser(AttachPermissionsRequest $request,$user){
        try{
            $this->repository->setModel(new User);
            $user=$this->repository->findOrFail($user);
            $user->attachPermissions($request->permission_ids);

            return ApiResponse::withOk('Permissions attached to user successfully');
        }
        catch(Exception $e){
            return ApiResponse::withException($e);
        }
    }
    function detachPermissionsFromUser(AttachPermissionsRequest $request,$user){
        try{
            $this->repository->setModel(new User);
            $user=$this->repository->findOrFail($user);
            $user->detachPermissions($request->permission_ids);

            return ApiResponse::withOk('Permissions detached from user successfully');
        }
        catch(Exception $e){
            return ApiResponse::withException($e);
        }
    }
}
