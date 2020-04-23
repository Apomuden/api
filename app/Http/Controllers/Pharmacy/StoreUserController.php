<?php

namespace App\Http\Controllers\Pharmacy;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiResponse;
use App\Http\Requests\Pharmacy\StoreUserRequest;
use App\Http\Resources\Pharmacy\StoreUserCollection;
use App\Http\Resources\Pharmacy\StoreUserResource;
use App\Models\StoreUser;
use App\Repositories\RepositoryEloquent;
use Exception;
use Illuminate\Http\Request;

class StoreUserController extends Controller
{
    protected $repository;

    public function __construct(StoreUser $StoreUser)
    {
        $this->repository= new RepositoryEloquent($StoreUser);
    }

    public function index(){

        return ApiResponse::withOk('Store Users list',new StoreUserCollection($this->repository->all('name')));
    }

    public function show($StoreUser){
        $StoreUser=$this->repository->show($StoreUser);
        return $StoreUser?
            ApiResponse::withOk('Store User Found',new StoreUserResource($StoreUser))
            : ApiResponse::withNotFound('Store User Not Found');
    }

    public function store(StoreUserRequest $StoreUserRequest){
        try{
            $requestData=$StoreUserRequest->all();
            $StoreUser=$this->repository->store($requestData);
            return ApiResponse::withOk('Store User created',new StoreUserResource($StoreUser->refresh()));
        }
        catch(Exception $e){
            return ApiResponse::withException($e);
        }
    }

    public function update(StoreUserRequest $StoreUserRequest,$StoreUser){
        try{
            $StoreUser=$this->repository->update($StoreUserRequest->all(),$StoreUser);
            return ApiResponse::withOk('Store User updated',new StoreUserResource($StoreUser));
        }
        catch(Exception $e){
            return ApiResponse::withException($e);
        }
    }
    public function destroy($id)
    {
        $this->repository->delete($id);
        return ApiResponse::withOk('Store User deleted successfully');
    }
}
