<?php

namespace App\Http\Controllers\Pharmacy;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiResponse;
use App\Http\Requests\Pharmacy\ProductCategoryRequest;
use App\Http\Resources\Pharmacy\ProductCategoryCollection;
use App\Http\Resources\Pharmacy\ProductCategoryResource;
use App\Models\ProductCategory;
use App\Repositories\RepositoryEloquent;
use Exception;
use Illuminate\Http\Request;

class ProductCategoryController extends Controller
{
    protected $repository;

    public function __construct(ProductCategory $ProductCategory)
    {
        $this->repository= new RepositoryEloquent($ProductCategory);
    }

    public function index(){

        return ApiResponse::withOk('Product Categories list',new ProductCategoryCollection($this->repository->all('name')));
    }

    public function show($ProductCategory){
        $ProductCategory=$this->repository->show($ProductCategory);
        return $ProductCategory?
            ApiResponse::withOk('Product Category Found',new ProductCategoryResource($ProductCategory))
            : ApiResponse::withNotFound('Product Category Not Found');
    }

    public function store(ProductCategoryRequest $ProductCategoryRequest){
        try{
            $requestData=$ProductCategoryRequest->all();
            $ProductCategory=$this->repository->store($requestData);
            return ApiResponse::withOk('Product Category created',new ProductCategoryResource($ProductCategory->refresh()));
        }
        catch(Exception $e){
            return ApiResponse::withException($e);
        }
    }

    public function update(ProductCategoryRequest $ProductCategoryRequest,$ProductCategory){
        try{
            $ProductCategory=$this->repository->update($ProductCategoryRequest->all(),$ProductCategory);
            return ApiResponse::withOk('Product Category updated',new ProductCategoryResource($ProductCategory));
        }
        catch(Exception $e){
            return ApiResponse::withException($e);
        }
    }
    public function destroy($id)
    {
        $this->repository->delete($id);
        return ApiResponse::withOk('Product Category deleted successfully');
    }
}
