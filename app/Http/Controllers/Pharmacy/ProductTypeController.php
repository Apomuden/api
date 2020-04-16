<?php

namespace App\Http\Controllers\Pharmacy;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiResponse;
use App\Http\Requests\Pharmacy\ProductTypeRequest;
use App\Http\Resources\Pharmacy\ProductTypeCollection;
use App\Http\Resources\Pharmacy\ProductTypeResource;
use App\Models\ProductType;
use App\Repositories\RepositoryEloquent;
use Exception;
use Illuminate\Http\Request;

class ProductTypeController extends Controller
{
    protected $repository;

    public function __construct(ProductType $ProductType)
    {
        $this->repository= new RepositoryEloquent($ProductType);
    }

    public function index(){

        return ApiResponse::withOk('Product Types list',new ProductTypeCollection($this->repository->all('name')));
    }

    public function show($ProductType){
        $ProductType=$this->repository->show($ProductType);
        return $ProductType?
            ApiResponse::withOk('Product Type Found',new ProductTypeResource($ProductType))
            : ApiResponse::withNotFound('Product Type Not Found');
    }

    public function store(ProductTypeRequest $ProductTypeRequest){
        try{
            $requestData=$ProductTypeRequest->all();
            $ProductType=$this->repository->store($requestData);
            return ApiResponse::withOk('Product Type created',new ProductTypeResource($ProductType->refresh()));
        }
        catch(Exception $e){
            return ApiResponse::withException($e);
        }
    }

    public function update(ProductTypeRequest $ProductTypeRequest,$ProductType){
        try{
            $ProductType=$this->repository->update($ProductTypeRequest->all(),$ProductType);
            return ApiResponse::withOk('Product Type updated',new ProductTypeResource($ProductType));
        }
        catch(Exception $e){
            return ApiResponse::withException($e);
        }
    }
    public function destroy($id)
    {
        $this->repository->delete($id);
        return ApiResponse::withOk('Product Type deleted successfully');
    }
}
