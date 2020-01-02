<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiResponse;
use App\Http\Requests\Auth\PermissionRequest;
use App\Http\Resources\ModulePermissionsCollection;
use App\Http\Resources\PermissionCollection;
use App\Http\Resources\PermissionResource;
use App\Models\Component;
use App\Models\Module;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use App\Repositories\RepositoryEloquent;
use Exception;
use Illuminate\Support\Facades\DB;

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

   function showByRole($role){
    $withPermissions=['permissions'=>function($q) use($role){$q->whereHas('roles',function($q2) use ($role){$q2->where('id',$role);});}];

     //$this->repository->setModel(new Role);
     //$permissions=$this->repository->find($role)->permissionspaginated()->paginate(10);
     $permissions=$this->repository->getInstanceWith($withPermissions)->paginate(10,'name');

     return ApiResponse::withPaginate(new PermissionCollection($permissions,'Available Permissions'));
   }

   function showHierarchyByRole($role){
       $withPermissions=['permissions'=>function($q) use($role){$q->whereHas('roles',function($q2) use ($role){$q2->where('id',$role);});}];
       $modules=Module::with(['components'=>function($q) use($withPermissions){$q->with($withPermissions);}])->sortBy('name')->paginate(10);


       return  ApiResponse::withPaginate(new ModulePermissionsCollection($modules,"Permissions hierachy"));
   }

   //get User Permissions
   function showPermissionHierarchy($user){
    $this->repository=new RepositoryEloquent(new User);

    $user=$this->repository->findOrFail($user);
    $withPermissions=['permissions'=>function($q) use($user){$q->whereHas('users',function($q2) use ($user){$q2->where('id',$user->id);});}];
    $modules=Module::with(['components'=>function($q) use($withPermissions){$q->with($withPermissions);}])->sortBy('name')->paginate(10);

    return  ApiResponse::withPaginate(new ModulePermissionsCollection($modules,"Permissions hierachy"));
   }

   function showPermissions($user){

     $this->repository=new RepositoryEloquent(new User);

     $user=$this->repository->findOrFail($user);

     $permissions=$user->permissions()->active()->sortBy('name')->get();

     return ApiResponse::withOk('Available Permissions',PermissionResource::collection($permissions));
   }
   function showPermissionsPaginated($user){
    $this->repository=new RepositoryEloquent(new User);

     $user=$this->repository->findOrFail($user);
      $permissions=$user->permissions()->active()->sortBy('name')->paginate(10);
     return ApiResponse::withPaginate(new PermissionCollection($permissions,'Available permissions'));
   }
}
