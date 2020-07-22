<?php

namespace App\Http\Controllers\Pharmacy;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiResponse;
use App\Http\Requests\Pharmacy\StockAdjustmentProductRequest;
use App\Http\Resources\Pharmacy\StockAdjustmentProductCollection;
use App\Http\Resources\Pharmacy\StockAdjustmentProductResource;
use App\Models\StockAdjustmentProduct;
use App\Repositories\RepositoryEloquent;
use Exception;

class StockAdjustmentProductController extends Controller
{
    protected $repository;

    public function __construct(StockAdjustmentProduct $StockAdjustmentProduct)
    {
        $this->repository = new RepositoryEloquent($StockAdjustmentProduct);
    }

    public function index()
    {

        return ApiResponse::withOk('Stock Adjustment Products list', new StockAdjustmentProductCollection($this->repository->all('name')));
    }

    public function show($StockAdjustmentProduct)
    {
        $StockAdjustmentProduct = $this->repository->show($StockAdjustmentProduct);
        return $StockAdjustmentProduct ?
            ApiResponse::withOk('Stock Adjustment Product Found', new StockAdjustmentProductResource($StockAdjustmentProduct))
            : ApiResponse::withNotFound('Stock Adjustment Product Not Found');
    }

    public function store(StockAdjustmentProductRequest $StockAdjustmentProductRequest)
    {
        try {
            $requestData = $StockAdjustmentProductRequest->all();
            $StockAdjustmentProduct = $this->repository->store($requestData);
            return ApiResponse::withOk('Stock Adjustment Product created', new StockAdjustmentProductResource($StockAdjustmentProduct->refresh()));
        } catch (Exception $e) {
            return ApiResponse::withException($e);
        }
    }

    public function update(StockAdjustmentProductRequest $StockAdjustmentProductRequest, $StockAdjustmentProduct)
    {
        try {
            $StockAdjustmentProduct = $this->repository->update($StockAdjustmentProductRequest->all(), $StockAdjustmentProduct);
            return ApiResponse::withOk('Stock Adjustment Product updated', new StockAdjustmentProductResource($StockAdjustmentProduct));
        } catch (Exception $e) {
            return ApiResponse::withException($e);
        }
    }
    public function destroy($id)
    {
        $this->repository->delete($id);
        return ApiResponse::withOk('Stock Adjustment Product deleted successfully');
    }
}
