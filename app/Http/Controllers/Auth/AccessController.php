<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiResponse;
use App\Http\Helpers\Security;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RecoveryMailRequest;
use Illuminate\Support\Str;
use App\Http\Resources\ProfileResource;
use App\Jobs\SendRecoveryMail;
use App\Models\PasswordReset;
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

            if($user->status=='ACTIVE' && !Security::confirmPassword($request->password,$user->password,$user->id))
                return ApiResponse::withNotAuthorized('Invalid username or password');
            else if($user->status=='RECOVERY_MODE'){
                $passwordReset=$user->recoveries()->where('recovered_at',null)->orderBy('created_at','DESC')->first();
                if(!$passwordReset)
                return ApiResponse::withNotAuthorized('Account recovery failed!');

                else if(date('Y-m-d H:i:s',strtotime($passwordReset->expiry_date))<now())
                return ApiResponse::withNotAuthorized('Account recovery expired!');

                else if(!Security::confirmPassword($request->password,$passwordReset->token,$user->id))
                return ApiResponse::withNotAuthorized('Invalid recovery password');

               // $passwordReset->recovered_at=Carbon::now();
               // $passwordReset->save();
            }
            else if($user->status!='ACTIVE')
            return ApiResponse::withNotAuthorized('Sorry you are '.$user->status);

                $user->last_login=Carbon::now();
                $user->save();
                $token=auth('api')->login($user);
                return $this->respondWithToken('Login successful',$token,$user);

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

    //sending recovery mail
    function sendRecoveryMail(RecoveryMailRequest $request){
        //try{
            $user=$this->repository->getModel()->where('email',$request->email)->first();
            if($user->status!='ACTIVE' && $user->status!='RECOVERY_MODE')
            return ApiResponse::withNotAuthorized('Sorry you are '.$user->status);

            $new_password=Str::random(8);
            $userToken=Security::getNewPasswordHash($new_password,$user->id);
            PasswordReset::create([
                'token'=>$userToken,
                'email'=>$request->email,
                'user_id'=>$user->id,
                'expiry_date'=>date('Y-m-d H:i:s',strtotime('+30 minutes')),
            ]);

            //update user status to recovery_mode
            $user->status='RECOVERY_MODE';
            $user->save();

            dispatch(new SendRecoveryMail($user->firstname,$user->email,$new_password));

            return ApiResponse::withOk('Recovery mail sent!');
       /*  }
        catch(Exception $e){
            return ApiResponse::withException($e);
        } */
    }
}
