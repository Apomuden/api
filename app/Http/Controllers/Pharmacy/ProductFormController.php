<?php

namespace App\Http\Controllers\Pharmacy;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiResponse;
use App\Http\Requests\Pharmacy\ProductFormRequest;
use App\Http\Resources\Pharmacy\ProductFormCollection;
use App\Http\Resources\Pharmacy\ProductFormResource;
use App\Models\ProductForm;
use App\Repositories\RepositoryEloquent;
use Exception;
use Illuminate\Http\Request;

class ProductFormController extends Controller
{
    protected $repository;

    public function __construct(ProductForm $ProductForm)
    {
        $this->repository= new RepositoryEloquent($ProductForm);
    }

    public function index(){

        return ApiResponse::withOk('Product Forms list',new ProductFormCollection($this->repository->all('name')));
    }

    public function show($ProductForm){
        $ProductForm=$this->repository->show($ProductForm);
        return $ProductForm?
            ApiResponse::withOk('Product Form Found',new ProductFormResource($ProductForm))
            : ApiResponse::withNotFound('Product Form Not Found');
    }

    public function store(ProductFormRequest $ProductFormRequest){
        try{
            $requestData=$ProductFormRequest->all();
            $ProductForm=$this->repository->store($requestData);
            return ApiResponse::withOk('Product Form created',new ProductFormResource($ProductForm->refresh()));
        }
        catch(Exception $e){
            return ApiResponse::withException($e);
        }
    }

    public function update(ProductFormRequest $ProductFormRequest,$ProductForm){
        try{
            $ProductForm=$this->repository->update($ProductFormRequest->all(),$ProductForm);
            return ApiResponse::withOk('Product Form updated',new ProductFormResource($ProductForm));
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
