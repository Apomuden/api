<?php

namespace App\Http\Controllers\Setups;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiResponse;
use App\Http\Requests\Setups\ServiceCategoryRequest;
use App\Http\Requests\Setups\ServiceSubCategoryRequest as SetupsServiceSubCategoryRequest;
use App\Http\Resources\ServiceSubCategoryCollection;
use App\Http\Resources\ServiceSubcategoryResource;
use App\Http\Resources\ServiceSubCategoryRequest;
use App\Models\ServiceCategory;
use App\Models\ServiceSubcategory;
use App\Repositories\RepositoryEloquent;
use Exception;

class ServiceSubCategoryController extends Controller
{
    protected $repository;

    public function __construct(ServiceSubcategory $serviceCategory)
    {
        $this->repository= new RepositoryEloquent($serviceCategory,true,['hospital_service','service_category']);
    }

    function index(){
        $serviceCategories=$this->repository->all('name');
        return ApiResponse::withOk('Service Sub Category list',new ServiceSubCategoryCollection($serviceCategories));
    }

    function show($serviceCategory){
        $serviceCategory=$this->repository->show($serviceCategory);//pass the country
        return $serviceCategory?
        ApiResponse::withOk('Service Sub Category Found',new ServiceSubcategoryResource($serviceCategory))
        : ApiResponse::withNotFound('Service Sub Category Not Found');
    }

   function store(SetupsServiceSubCategoryRequest $serviceCategoryRequest){
       try{
           $requestData=$serviceCategoryRequest->all();

           $CategoryRepo=new RepositoryEloquent(new ServiceCategory);
           $serviceCategory=$CategoryRepo->find($requestData['service_category_id']);

           $requestData['hospital_service_id']=$serviceCategory->hospital_service_id;

           $serviceCategory=$this->repository->store($requestData);
          return ApiResponse::withOk('Service Sub Category created',new ServiceSubcategoryResource($serviceCategory->refresh()));
      }
       catch(Exception $e){
         return ApiResponse::withException($e);
       }
   }

   function update(SetupsServiceSubCategoryRequest $ServiceCategoryRequest,$serviceCategory){
       try{
        $serviceCategory=$this->repository->update($ServiceCategoryRequest->all(),$serviceCategory);

        return ApiResponse::withOk('Service Sub Category updated',new ServiceSubcategoryResource($serviceCategory));
      }
       catch(Exception $e){
        return ApiResponse::withException($e);
       }
   }
    public function destroy($id)
    {
        $this->repository->delete($id);
        return ApiResponse::withOk('Service sub category deleted successfully');
    }
   function showByServiceCategory($serviceCategory){
       $this->repository->setModel(new ServiceCategory,['service_subcategories'=>function($query){
           $query->active()->orderBy('name');
       }]);
      $service_subcategories=$this->repository->find($serviceCategory)->service_subcategories()->get();
      return $service_subcategories?
      ApiResponse::withOk('Available Service Sub Categories Found',new ServiceSubCategoryCollection($service_subcategories))
      : ApiResponse::withNotFound('Available Service Sub Categories Not Found');
   }

}
