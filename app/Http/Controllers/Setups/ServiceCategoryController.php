<?php

namespace App\Http\Controllers\Setups;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiResponse;
use App\Http\Requests\Setups\ServiceCategoryRequest;
use App\Http\Resources\ServiceCategoryCollection;
use App\Http\Resources\ServiceCategoryResource;
use App\Models\Company;
use App\Models\Hospital;
use App\Models\HospitalService;
use App\Models\ServiceCategory;
use App\Repositories\RepositoryEloquent;
use Exception;

class ServiceCategoryController extends Controller
{
    protected $repository;

    public function __construct(ServiceCategory $serviceCategory)
    {
        $this->repository = new RepositoryEloquent($serviceCategory);
    }

    function index()
    {
        $serviceCategories = $this->repository->getInstanceWith('hospital_service')->all('name');
        return ApiResponse::withOk('Service Category list', new ServiceCategoryCollection($serviceCategories));
    }

    function show($serviceCategory)
    {
        $serviceCategory = $this->repository->getInstanceWith('hospital_service')->show($serviceCategory);//pass the country
        return $serviceCategory ?
        ApiResponse::withOk('Service Category Found', new ServiceCategoryResource($serviceCategory))
        : ApiResponse::withNotFound('Service Category Not Found');
    }

    function store(ServiceCategoryRequest $serviceCategoryRequest)
    {
        try {
            $requestData = $serviceCategoryRequest->all();

            $serviceCategory = $this->repository->store($requestData);
            return ApiResponse::withOk('Service Category created', new ServiceCategoryResource($serviceCategory->refresh()));
        } catch (Exception $e) {
            return ApiResponse::withException($e);
        }
    }

    function update(ServiceCategoryRequest $ServiceCategoryRequest, $serviceCategory)
    {
        try {
            $serviceCategory = $this->repository->update($ServiceCategoryRequest->all(), $serviceCategory);

            return ApiResponse::withOk('Service Category updated', new ServiceCategoryResource($serviceCategory));
        } catch (Exception $e) {
            return ApiResponse::withException($e);
        }
    }
    public function destroy($id)
    {
        $this->repository->delete($id);
        return ApiResponse::withOk('Service category deleted successfully');
    }
    function showByHospitalService($hospitalservice)
    {
        $this->repository->setModel(new HospitalService(), ['service_categories' => function ($query) {
            $query->active()->orderBy('name');
        }]);
        $service_categories = $this->repository->find($hospitalservice)->service_categories()->get();
        return $service_categories ?
        ApiResponse::withOk('Available Service Categories Found', new ServiceCategoryCollection($service_categories))
        : ApiResponse::withNotFound('Available Service Categories Not Found');
    }
}
