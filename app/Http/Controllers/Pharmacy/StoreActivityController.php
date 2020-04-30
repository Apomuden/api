<?php

namespace App\Http\Controllers\Pharmacy;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiResponse;
use App\Http\Requests\Pharmacy\StoreActivityRequest;
use App\Http\Resources\Pharmacy\StoreActivityCollection;
use App\Http\Resources\Pharmacy\StoreActivityResource;
use App\Models\StoreActivity;
use App\Repositories\RepositoryEloquent;
use Exception;
use Illuminate\Http\Request;

class StoreActivityController extends Controller
{
    protected $repository;

    public function __construct(StoreActivity $StoreActivity)
    {
        $this->repository= new RepositoryEloquent($StoreActivity);
    }

    public function index(){

        return ApiResponse::withOk('Product Forms list',new StoreActivityCollection($this->repository->all('name')));
    }

    public function show($StoreActivity){
        $StoreActivity=$this->repository->show($StoreActivity);
        return $StoreActivity?
            ApiResponse::withOk('Product Form Found',new StoreActivityResource($StoreActivity))
            : ApiResponse::withNotFound('Product Form Not Found');
    }

    public function store(StoreActivityRequest $StoreActivityRequest){
        try{
            $requestData=$StoreActivityRequest->all();
            $StoreActivity=$this->repository->store($requestData);
            return ApiResponse::withOk('Product Form created',new StoreActivityResource($StoreActivity->refresh()));
        }
        catch(Exception $e){
            return ApiResponse::withException($e);
        }
    }

    public function update(StoreActivityRequest $StoreActivityRequest,$StoreActivity){
        try{
            $StoreActivity=$this->repository->update($StoreActivityRequest->all(),$StoreActivity);
            return ApiResponse::withOk('Product Form updated',new StoreActivityResource($StoreActivity));
        }
        catch(Exception $e){
            return ApiResponse::withException($e);
        }
    }
    public function destroy($id)
    {
        $this->repository->delete($id);
        return ApiResponse::withOk('Product Form deleted successfully');
    }
}
