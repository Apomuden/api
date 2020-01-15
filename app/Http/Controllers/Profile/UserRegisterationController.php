<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiRequest;
use App\Http\Helpers\ApiResponse;
use App\Http\Requests\Profile\ProfileRequest;
use App\Http\Resources\ProfilePaginatedCollection;
use App\Http\Resources\ProfileResource;
use App\Http\Resources\ProfileWithIDResource;
use App\Models\User;
use App\Repositories\RepositoryEloquent;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Request;

class UserRegisterationController extends Controller
{
   protected $repository;
   public function __construct(User $user)
   {
      $this->repository=new RepositoryEloquent($user);
   }
   function index(){
        $this->repository->useActiveTrait=false;
        $users=$this->repository->paginate(10,'username');

        return ApiResponse::withPaginate(new ProfilePaginatedCollection($users,'List of users'));
   }

   function show($profile)
   {
      $profile=$this->repository->find($profile);
      return ApiResponse::withOk('Profile found',new ProfileWithIDResource($profile));
   }

  /*  function search(){
      $params=\request()->query();
      if($params)
      $users=$this->repository->getModel()->findBy($params)->sortBy('username')->paginate(10);
      else
      $users=$this->repository->paginate(10,'username');
      return ApiResponse::withPaginate(new ProfilePaginatedCollection($users,'List of found users'));
   } */

   function store(ProfileRequest $request)
   {
       $profile=$this->repository->store($request->all());
       return ApiResponse::withOk('Profile created',new ProfileWithIDResource($profile->refresh()));
   }

   function update(ProfileRequest $request,$profile){
        $profile=$this->repository->update($request->all(),$profile);
        return ApiResponse::withOk('Profile updated',new ProfileWithIDResource($profile->refresh()));
   }

    public function destroy($id)
    {
        $this->repository->delete($id);
        return ApiResponse::withOk('Profile deleted successfully');
    }
}
