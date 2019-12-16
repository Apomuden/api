<?php

namespace App\Http\Controllers\Setups;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiResponse;
use App\Http\Requests\Setups\StaffCategoryRequest;
use App\Http\Resources\GeneralCollection;
use App\Http\Resources\GeneralResource;
use App\Models\StaffCategory;
use App\Repositories\RepositoryEloquent;
use Exception;
use Illuminate\Http\Request;

class StaffCategoryController extends Controller
{
    protected $repository;

    public function __construct(StaffCategory $category)
    {
        $this->repository= new RepositoryEloquent($category);
    }

    function index(){
        return ApiResponse::withOk('Staff Category list',new GeneralCollection($this->repository->all('name')));
    }

    function show($language){
        $language=$this->repository->show($language);//pass the country
        return $language?
        ApiResponse::withOk('Staff Category Found',new GeneralResource($language))
        : ApiResponse::withNotFound('Staff Category Not Found');
    }

   function store(StaffCategoryRequest $staffCategoryRequest){
       try{
           $requestData=$staffCategoryRequest->all();
           $category=$this->repository->store($requestData);
           return ApiResponse::withOk('Staff Category created',new GeneralResource($category->refresh()));
       }
       catch(Exception $e){
         return ApiResponse::withException($e);
       }
   }

   function update(StaffCategoryRequest $staffCategoryRequest,$category){
       try{
        $category=$this->repository->update($staffCategoryRequest->all(),$category);
        return ApiResponse::withOk('Staff Category updated',new GeneralResource($category));
       }
       catch(Exception $e){
        return ApiResponse::withException($e);
       }
   }
}
