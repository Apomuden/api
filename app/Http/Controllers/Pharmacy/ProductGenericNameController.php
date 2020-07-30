<?php

namespace App\Http\Controllers\Pharmacy;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiResponse;
use App\Http\Requests\Pharmacy\ProductGenericNameRequest;
use App\Http\Resources\Pharmacy\ProductGenericNameCollection;
use App\Http\Resources\Pharmacy\ProductGenericNameResource;
use App\Models\ProductGenericName;
use App\Repositories\RepositoryEloquent;
use Exception;
use Illuminate\Http\Request;

class ProductGenericNameController extends Controller
{
    protected $repository;

    public function __construct(ProductGenericName $ProductGenericName)
    {
        $this->repository= new RepositoryEloquent($ProductGenericName);
    }

    public function index(){

        return ApiResponse::withOk('Product Generic Names list',new ProductGenericNameCollection($this->repository->all('name')));
    }

    public function show($ProductGenericName){
        $ProductGenericName=$this->repository->show($ProductGenericName);
        return $ProductGenericName?
            ApiResponse::withOk('Product Generic Name Found',new ProductGenericNameResource($ProductGenericName))
            : ApiResponse::withNotFound('Product Generic Name Not Found');
    }

    public function store(ProductGenericNameRequest $ProductGenericNameRequest){
        try{
            $requestData=$ProductGenericNameRequest->all();
            $ProductGenericName=$this->repository->store($requestData);
            return ApiResponse::withOk('Product Generic Name created',new ProductGenericNameResource($ProductGenericName->refresh()));
        }
        catch(Exception $e){
            return ApiResponse::withException($e);
        }
    }

    public function update(ProductGenericNameRequest $ProductGenericNameRequest,$ProductGenericName){
        try{
            $ProductGenericName=$this->repository->update($ProductGenericNameRequest->all(),$ProductGenericName);
            return ApiResponse::withOk('Product Generic Name updated',new ProductGenericNameResource($ProductGenericName));
        }
        catch(Exception $e){
            return ApiResponse::withException($e);
        }
    }

    public function destroy($id)
    {
        $this->repository->delete($id);
        return ApiResponse::withOk('Product Generic Name deleted successfully');
    }
}
