<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiResponse;
use App\Http\Resources\ComponentPermissionsCollection;
use App\Http\Resources\ComponentPermissionsResource;
use App\Http\Resources\ModulePermissionsCollection;
use App\Http\Resources\ModulePermissionsResource;
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
        $module=request('module');
        $parent_tag=request('parent_tag');
         $component= request('component');

        $modules = Module::active()->sortBy('name');

        if($module)
        $modules->where('modules.id',$module)->orWhere('modules.tag',$module);

        if($parent_tag)
        $modules->where('modules.parent_tag',$parent_tag);

        if($component)
        $modules->whereHas('components',function($q1) use($component){
               $q1->where('components.id',$component)->orWhere('components.tag',$component);
        })->with(['components'=>function($q2) use($component){
               $q2->where('components.id',$component)->orWhere('components.tag',$component)->take(1);
        }]);

        $modules=$modules->paginate(10);
        $records = new ModulePermissionsCollection($modules, "Components hierachy");

        return  ApiResponse::withPaginate($records);
    }
    function showHierarchyByRole($role)
    {

        $modules = Module::active()->with(['components'=>function($q1) use($role){
                    $q1->whereHas('roles',function($q2) use ($role){
                          $q2->where('roles.id', $role);
                    });
        }])->sortBy('name');

        $module = request('module');
        $parent_tag = request('parent_tag');
        $component = request('component');

        if ($module)
        $modules->where('modules.id', $module)->orWhere('modules.tag', $module);

        if ($parent_tag)
        $modules->where('modules.parent_tag', $parent_tag);

        if ($component)
        $modules->whereHas('components', function ($q1) use ($component) {
            $q1->where('components.id', $component)->orWhere('components.tag', $component);
        });


        $modules=$modules->paginate(10);
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
    function showPermission($user)
    {
        $modules = Module::active()
        ->select('modules.*')
        ->leftJoin('component_user','modules.id','=', 'component_user.module_id')
        ->where('component_user.user_id',$user)->distinct()
        ->get();

        return  ApiResponse::withOk('User Modules Hierarchy',ModulePermissionsResource::collection($modules));
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
