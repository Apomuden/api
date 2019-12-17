<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiResponse;
use App\Http\Helpers\Security;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Resources\ProfileBasicResource;
use App\Http\Resources\ProfileResource;
use App\Models\User;
use App\Repositories\RepositoryEloquent;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;

class AccessController extends Controller
{
    protected $repository;

    public function __construct(User $user)
    {
        $this->repository= new RepositoryEloquent($user);
    }
    function login(LoginRequest $request){
        try{
            $user=$this->repository->getModel()->where('username',$request->username)->first();
            if(!$user)
            return ApiResponse::withNotAuthorized('User not found');

            if(!Security::confirmPassword($request->password,$user->password,$user->id))
                return ApiResponse::withNotAuthorized('Invalid username or password');
            else{
                $user->last_login=Carbon::now();
                $user->save();
                $token=auth('api')->login($user);
                return $this->respondWithToken('Login successful',$token,$user);
            }
        }
        catch(Exception $e){
                return ApiResponse::withException($e);
        }
    }

    function logout(){
        try{
            $user=Auth::guard('api')->user();
            $user->last_logout=Carbon::now();
            auth('api')->logout();
            return ApiResponse::withOk('Logout successful!');
        }
        catch(Exception $e){
           return ApiResponse::withException($e);
        }
    }
    function refresh(){
        try{
            return $this->respondWithToken(auth('api')->refresh());
        }
        catch(Exception $e){
            return ApiResponse::withException($e);
        }
    }
    protected function respondWithToken($message,$token,$user=null)
    {

        $data= [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => (auth('api')->factory()->getTTL()/60).' hours',
            'profile'=>$user?new ProfileResource($user):null
        ];

      return  ApiResponse::withOk($message,$data);
    }
}
