<?php

namespace App\Http\Controllers\Pharmacy;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiResponse;
use App\Http\Requests\Pharmacy\ProductsRequest;
use App\Http\Resources\Pharmacy\ProductsCollection;
use App\Http\Resources\Pharmacy\ProductsResource;
use App\Models\Products;
use App\Repositories\RepositoryEloquent;
use Exception;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    protected $repository;

    public function __construct(Products $Products)
    {
        $this->repository= new RepositoryEloquent($Products);
    }

    public function index(Request $request) {
        $paginate = trim(\request()->request->get('paginate'));

        $paginate = $paginate=='false' ? false : true;
        \request()->request->remove('paginate');

        return ApiResponse::withPaginate(
            new ProductsCollection($this->repository->paginate(15,'brand_name'),
                'Products List', $paginate));
    }

    public function show($Products){
        $Products=$this->repository->show($Products);
        return $Products?
            ApiResponse::withOk('Product Found',new ProductsResource($Products))
            : ApiResponse::withNotFound('Product Not Found');
    }

    public function store(ProductsRequest $ProductsRequest){
        try{
            $requestData=$ProductsRequest->all();
            $Products=$this->repository->store($requestData);
            return ApiResponse::withOk('Product created',
                new ProductsResource($Products->refresh()));
        }
        catch(Exception $e){
            return ApiResponse::withException($e);
        }
    }

    public function update(ProductsRequest $ProductsRequest,$Products){
        try{
            $Products=$this->repository->update($ProductsRequest->all(),$Products);
            return ApiResponse::withOk('Product updated',new ProductsResource($Products));
        }
        catch(Exception $e){
            return ApiResponse::withException($e);
        }
    }
    public function destroy($id)
    {
        $this->repository->delete($id);
        return ApiResponse::withOk('Product deleted successfully');
    }
}
