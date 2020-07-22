<?php

namespace App\Http\Controllers\Pharmacy;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiResponse;
use App\Http\Requests\Pharmacy\ProductFormUnitRequest;
use App\Http\Resources\Pharmacy\ProductFormUnitCollection;
use App\Http\Resources\Pharmacy\ProductFormUnitResource;
use App\Models\ProductFormUnit;
use App\Repositories\RepositoryEloquent;
use Exception;
use Illuminate\Http\Request;

class ProductFormUnitController extends Controller
{
    protected $repository;

    public function __construct(ProductFormUnit $ProductFormUnit)
    {
        $this->repository = new RepositoryEloquent($ProductFormUnit);
    }

    public function index()
    {

        return ApiResponse::withOk('Product Form Units list', new ProductFormUnitCollection($this->repository->all('name')));
    }

    public function show($ProductFormUnit)
    {
        $ProductFormUnit = $this->repository->show($ProductFormUnit);
        return $ProductFormUnit ?
            ApiResponse::withOk('Product Form Unit Found', new ProductFormUnitResource($ProductFormUnit))
            : ApiResponse::withNotFound('Product Form Unit Not Found');
    }

    public function store(ProductFormUnitRequest $ProductFormUnitRequest)
    {
        try {
            $requestData = $ProductFormUnitRequest->all();
            $ProductFormUnit = $this->repository->store($requestData);
            return ApiResponse::withOk('Product Form Unit created', new ProductFormUnitResource($ProductFormUnit->refresh()));
        } catch (Exception $e) {
            return ApiResponse::withException($e);
        }
    }

    public function update(ProductFormUnitRequest $ProductFormUnitRequest, $ProductFormUnit)
    {
        try {
            $ProductFormUnit = $this->repository->update($ProductFormUnitRequest->all(), $ProductFormUnit);
            return ApiResponse::withOk('Product Form Unit updated', new ProductFormUnitResource($ProductFormUnit));
        } catch (Exception $e) {
            return ApiResponse::withException($e);
        }
    }
    public function destroy($id)
    {
        $this->repository->delete($id);
        return ApiResponse::withOk('Product Form Unit deleted successfully');
    }
}
