<?php

namespace App\Http\Controllers\Pharmacy;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiResponse;
use App\Http\Requests\Pharmacy\StockRequest;
use App\Http\Resources\Pharmacy\StockCollection;
use App\Http\Resources\Pharmacy\StockResource;
use App\Models\Stock;
use App\Repositories\RepositoryEloquent;
use Exception;

class StockController extends Controller
{
    protected $repository;

    public function __construct(Stock $Stock)
    {
        $this->repository = new RepositoryEloquent($Stock);
    }

    public function index()
    {

        return ApiResponse::withOk('Stock Adjustment Products list', new StockCollection($this->repository->all('name')));
    }

    public function show($Stock)
    {
        $Stock = $this->repository->show($Stock);
        return $Stock ?
            ApiResponse::withOk('Stock Adjustment Product Found', new StockResource($Stock))
            : ApiResponse::withNotFound('Stock Adjustment Product Not Found');
    }

    public function store(StockRequest $StockRequest)
    {
        try {
            $requestData = $StockRequest->all();
            $Stock = $this->repository->store($requestData);
            return ApiResponse::withOk('Stock Adjustment Product created', new StockResource($Stock->refresh()));
        } catch (Exception $e) {
            return ApiResponse::withException($e);
        }
    }

    public function update(StockRequest $StockRequest, $Stock)
    {
        try {
            $Stock = $this->repository->update($StockRequest->all(), $Stock);
            return ApiResponse::withOk('Stock Adjustment Product updated', new StockResource($Stock));
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
