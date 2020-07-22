<?php

namespace App\Http\Controllers\Setups;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiResponse;
use App\Http\Requests\Setups\AgeCategoryRequest;
use App\Http\Resources\AgeCategoryCollection;
use App\Http\Resources\AgeCategoryResource;
use App\Models\AgeCategory;
use App\Repositories\RepositoryEloquent;
use Exception;
use Illuminate\Http\Request;

class AgeCategoryController extends Controller
{
    protected $repository;

    public function __construct(AgeCategory $ageCategory)
    {
        $this->repository = new RepositoryEloquent($ageCategory);
    }

    public function index()
    {

        return ApiResponse::withOk('AgeCategory list', new AgeCategoryCollection($this->repository->all('name')));
    }

    public function show($AgeCategory)
    {
        $AgeCategory = $this->repository->show($AgeCategory);//pass the country
        return $AgeCategory ?
            ApiResponse::withOk('AgeCategory Found', new AgeCategoryResource($AgeCategory))
            : ApiResponse::withNotFound('AgeCategory Not Found');
    }

    public function store(AgeCategoryRequest $AgeCategoryRequest)
    {
        try {
            $requestData = $AgeCategoryRequest->all();

            $AgeCategory = $this->repository->store($requestData);
            return ApiResponse::withOk('AgeCategory created', new AgeCategoryResource($AgeCategory->refresh()));
        } catch (Exception $e) {
            return ApiResponse::withException($e);
        }
    }

    public function update(AgeCategoryRequest $AgeCategoryRequest, $id)
    {
        try {
            $AgeCategory = $this->repository->update($AgeCategoryRequest->all(), $id);

            return ApiResponse::withOk('AgeCategory updated', new AgeCategoryResource($AgeCategory));
        } catch (Exception $e) {
            return ApiResponse::withException($e);
        }
    }
    public function destroy($id)
    {
        $this->repository->delete($id);
        return ApiResponse::withOk('AgeCategory deleted successfully');
    }
}
