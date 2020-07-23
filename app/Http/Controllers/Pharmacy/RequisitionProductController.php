<?php

namespace App\Http\Controllers\Pharmacy;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiResponse;
use App\Http\Requests\Pharmacy\RequisitionProductRequest; //TODO: Make Sure to change to the correct Request namespace
use App\Http\Resources\Pharmacy\RequisitionProductCollection; //TODO: Make Sure to change to the correct Collection namespace
use App\Http\Resources\Pharmacy\RequisitionProductResource; //TODO: Make Sure to change to the correct Resource namespace
use App\Models\Requisition;
use App\Models\RequisitionProduct; //TODO: Make Sure to change to the correct Model namespace
use App\Repositories\RepositoryEloquent;
use Exception;
use Illuminate\Http\Request;

class RequisitionProductController extends Controller
{
    protected $repository;

    public function __construct(RequisitionProduct $RequisitionProduct)
    {
        $this->repository = new RepositoryEloquent($RequisitionProduct);
    }

    public function index($requisitionId=null)
    {
        $query = $this->repository->all('name');
        if ($requisitionId) {
            $refNumber = Requisition::query()->find($requisitionId);
            $refNumber = $refNumber ? $refNumber->reference_number : null;
            $query = $query->where(['reference_number'=>$refNumber]);
        }
        return ApiResponse::withOk('RequisitionProducts list', new RequisitionProductCollection($query));
    }

    public function show($RequisitionProduct)
    {
        $RequisitionProduct = $this->repository->show($RequisitionProduct);
        return $RequisitionProduct ?
            ApiResponse::withOk('RequisitionProduct Found', new RequisitionProductResource($RequisitionProduct))
            : ApiResponse::withNotFound('RequisitionProduct Not Found');
    }

    public function store(RequisitionProductRequest $RequisitionProductRequest)
    {
        try {
            $requestData = $RequisitionProductRequest->all();
            $RequisitionProduct = $this->repository->store($requestData);
            return ApiResponse::withOk('RequisitionProduct created', new RequisitionProductResource($RequisitionProduct->refresh()));
        } catch (Exception $e) {
            return ApiResponse::withException($e);
        }
    }

    public function update(RequisitionProductRequest $RequisitionProductRequest, $RequisitionProduct)
    {
        try {
            $RequisitionProduct = $this->repository->update($RequisitionProductRequest->all(), $RequisitionProduct);
            return ApiResponse::withOk('RequisitionProduct updated', new RequisitionProductResource($RequisitionProduct));
        } catch (Exception $e) {
            return ApiResponse::withException($e);
        }
    }

    public function destroy($id)
    {
        $this->repository->delete($id);
        return ApiResponse::withOk('RequisitionProduct deleted successfully');
    }
}
