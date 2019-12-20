<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiResponse;
use App\Http\Requests\Profile\ProfileNextOfKinRequest;
use App\Http\Resources\ProfileNextOfKinCollection;
use App\Http\Resources\ProfileNextOfKinResource;
use App\Models\StaffNextOfKin;
use App\Models\User;
use App\Repositories\RepositoryEloquent;
use Exception;

class ProfileNextOfKinController extends Controller
{
    protected $repository;

    public function __construct(StaffNextOfKin $nextofkin)
    {
        $this->repository= new RepositoryEloquent($nextofkin,true,['user','relationship']);
    }

    function index(){

        return ApiResponse::withOk('Profile Next of Kin list',new ProfileNextOfKinCollection($this->repository->all('name')));
    }

    function show($profilenextofkin){
        $profilenextofkin=$this->repository->show($profilenextofkin);//pass the country
        return $profilenextofkin?
        ApiResponse::withOk('Profile Next of Kin Found',new ProfileNextOfKinResource($profilenextofkin))
        : ApiResponse::withNotFound('Profile Next of Kin Not Found');
    }

   function store(ProfileNextOfKinRequest $profileNextOfKin){
       try{
           $requestData=$profileNextOfKin->all();

           $profileNextOfKin=$this->repository->store($requestData);
        return ApiResponse::withOk('Profile Next of Kin created',new ProfileNextOfKinResource($profileNextOfKin->refresh()));
       }
       catch(Exception $e){
         return ApiResponse::withException($e);
       }
   }

   function update(ProfileNextOfKinRequest $profileNextOfKinRequest,$profileNextOfKin){
       try{
        $profileNextOfKin=$this->repository->update($profileNextOfKinRequest->all(),$profileNextOfKin);

        return ApiResponse::withOk('Profile Next of Kin updated',new ProfileNextOfKinResource($profileNextOfKin));

       }
       catch(Exception $e){
        return ApiResponse::withException($e);
       }
   }

   function showByProfile($profile){
       $this->repository->setModel(new User,['nextofkins'=>function($query){
           $query->active()->with(['relationship','user'])->orderBy('name');
       }]);
       $nextofkins=$this->repository->find($profile)->nextofkins??null;

       return $nextofkins?
       ApiResponse::withOk('Available Documents Found',new ProfileNextOfKinCollection($nextofkins))
       : ApiResponse::withNotFound('Profile Next of Kins Not Found');
   }


}
