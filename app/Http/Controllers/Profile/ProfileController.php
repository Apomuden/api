<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiResponse;
use App\Http\Requests\Profile\ProfileRequest;
use App\Http\Resources\ProfileResource;
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

   
}
