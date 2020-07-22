<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiResponse;
use App\Http\Resources\ComponentPermissionsCollection;
use App\Http\Resources\ComponentPermissionsResource;
use App\Http\Resources\ModulePermissionsCollection;
use App\Models\Component;
use App\Models\Module;
use App\Models\User;
use App\Repositories\RepositoryEloquent;
use Illuminate\Support\Facades\DB;

class PermissionController extends Controller
{
    protected $repository;

    public function __construct(Component $component)
    {
        $this->repository = new RepositoryEloquent($component, true, ['module']);
    }
    function showByRole($role)
    {
        $components = $this->repository->getModel()->whereHas('roles', function ($q2) use ($role) {
            $q2->where('roles.id', $role);
        })->orderBy('name')->get();

        return ApiResponse::withOk('Available Components', new ComponentPermissionsCollection($components));
    }
    function showHierarchy()
    {
        //DB::enableQueryLog();
        $modules = Module::active()->sortBy('name')->paginate(10);
        $records = new ModulePermissionsCollection($modules, "Components hierachy");

        return  ApiResponse::withPaginate($records);
    }
    function showHierarchyByRole($role)
    {
        //DB::enableQueryLog();
        $modules = Module::active()->whereHas('roles', function ($q2) use ($role) {
            $q2->where('roles.id', $role);
        })->sortBy('name')->paginate(10);

        return  ApiResponse::withPaginate(new ModulePermissionsCollection($modules, "Components hierachy"));
    }
   //get User Component Permissions
    function showPermissionHierarchy($user)
    {
        $modules = Module::active()->whereHas('users', function ($q2) use ($user) {
            $q2->where('users.id', $user);
        })->sortBy('name')->paginate(10);

        return  ApiResponse::withPaginate(new ModulePermissionsCollection($modules, "Components hierachy"));
    }

    //get User Component Permissions
    function showPermissions($user)
    {

        $this->repository = new RepositoryEloquent(new User());

        $user = $this->repository->findOrFail($user);

        $components = $user->components()->active()->sortBy('name')->get();

        return ApiResponse::withOk('Available Components', ComponentPermissionsResource::collection($components));
    }
}
