<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiResponse;
use App\Http\Requests\Profile\ProfileRequest;
use App\Http\Resources\ModulePermissionsCollection;
use App\Http\Resources\PermissionCollection;
use App\Http\Resources\PermissionResource;
use App\Http\Resources\ProfileResource;
use App\Models\Module;
use App\Models\User;
use App\Repositories\RepositoryEloquent;
use Exception;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    protected $repository;

    public function __construct(User $user)
    {
        $this->repository= new RepositoryEloquent($user);
    }

   public function update(ProfileRequest $profileRequest){
       try{
        $user=Auth::guard('api')->user();
        $profile=$this->repository->update($profileRequest->all(),$user->id);
        return ApiResponse::withOk('Profile updated',new ProfileResource($profile));
        }
       catch(Exception $e){
           return ApiResponse::withException($e);
       }
   }

   function showPermissionHierarchy(){
    $user=Auth::guard('api')->user();

    $withPermissions=['permissions'=>function($q) use($user){$q->whereHas('users',function($q2) use ($user){$q2->where('id',$user->id);});}];
    $modules=Module::with(['components'=>function($q) use($withPermissions){$q->with($withPermissions);}])->sortBy('name')->paginate(10);

    return  ApiResponse::withPaginate(new ModulePermissionsCollection($modules,"Permissions hierachy"));
   }

   function showPermissions(){
     $user=Auth::guard('api')->user();
     $permissions=$user->permissions()->active()->sortBy('name')->get();
     return ApiResponse::withOk('Available Permissions',PermissionResource::collection($permissions));
   }
   function showPermissionsPaginated(){
     $user=Auth::guard('api')->user();
     $permissions=$user->permissions()->active()->sortBy('name')->paginate(10);
     return ApiResponse::withPaginate(new PermissionCollection($permissions,'Available permissions'));
   }
}
