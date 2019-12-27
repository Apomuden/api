<?php

namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\AttacheModuleToRoleRequest;
use App\Models\Role;
use App\Repositories\RepositoryEloquent;
use Illuminate\Http\Request;
use App\Http\Helpers\ApiResponse;
use Exception;

class AuthorizationController extends Controller
{
    protected $repository;

    public function __construct(Role $role)
    {
        $this->repository= new RepositoryEloquent($role);
    }

    function attchModulesToRole(AttacheModuleToRoleRequest $request,$role){
        //try{
            $role=$this->repository->findOrFail($role);

            $role->attachModules($request->module_ids);

            return ApiResponse::withOk('Modules attached to role successfully');
       /*  }
        catch(Exception $e){
            return ApiResponse::withException($e);
        } */
    }
}
