<?php

namespace App\Http\Controllers\Setups;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiResponse;
use App\Http\Requests\Setups\MajorDiagnosticCategoryRequest;
use App\Http\Resources\MajorDiagnosticCategoryResource;
use App\Models\MajorDiagnosticCategory;
use App\Repositories\RepositoryEloquent;
use Exception;

class MajorDiagnosticCategoryController extends Controller
{
    protected $repository;

    public function __construct(MajorDiagnosticCategory $majorDiagnosticCategory)
    {
        $this->repository = new RepositoryEloquent($majorDiagnosticCategory);
    }

    function index()
    {

        return ApiResponse::withOk('Major diagnostic category list', MajorDiagnosticCategoryResource::collection($this->repository->all('name')));
    }

    function show($NHIS)
    {
        $majorDiagnosticCategory = $this->repository->show($NHIS);//pass the country
        return $majorDiagnosticCategory ?
        ApiResponse::withOk('Major diagnostic category Found', new MajorDiagnosticCategoryResource($NHIS))
        : ApiResponse::withNotFound('Major diagnostic category Found');
    }

    function store(MajorDiagnosticCategoryRequest $majorDiagnosticCategoryRequest)
    {
        //try{
           $requestData = $majorDiagnosticCategoryRequest->all();

           $majorDiagnosticCategory = $this->repository->store($requestData);
        return ApiResponse::withOk('Major diagnostic category created', new MajorDiagnosticCategoryResource($majorDiagnosticCategory->refresh()));
       /*  }
       catch(Exception $e){
         return ApiResponse::withException($e);
        } */
    }

    function update(MajorDiagnosticCategoryRequest $majorDiagnosticCategoryRequest, $id)
    {
        try {
            $majorDiagnosticCategory = $this->repository->update($majorDiagnosticCategoryRequest->all(), $id);

            return ApiResponse::withOk('Major diagnostic category updated', new MajorDiagnosticCategoryResource($majorDiagnosticCategory));
        } catch (Exception $e) {
            return ApiResponse::withException($e);
        }
    }
    public function destroy($id)
    {
        $this->repository->delete($id);
        return ApiResponse::withOk('Major diagnostic category deleted successfully');
    }
}
