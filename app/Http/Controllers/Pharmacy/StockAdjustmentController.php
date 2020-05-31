<?php

namespace App\Http\Controllers\Pharmacy;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiResponse;
use App\Http\Requests\Pharmacy\StockAdjustmentApprovalRequest;
use App\Http\Requests\Pharmacy\StockAdjustmentRequest;
use App\Http\Resources\Pharmacy\StockAdjustmentCollection;
use App\Http\Resources\Pharmacy\StockAdjustmentResource;
use App\Models\StockAdjustment;
use App\Models\StockAdjustmentProduct;
use App\Repositories\RepositoryEloquent;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StockAdjustmentController extends Controller
{
    protected $repository;

    public function __construct(StockAdjustment $StockAdjustment)
    {
        $this->repository= new RepositoryEloquent($StockAdjustment);
    }

    public function index(){

        return ApiResponse::withOk('Stock Adjustments list',new StockAdjustmentCollection($this->repository->all('name')));
    }

    public function show($StockAdjustment){
        $StockAdjustment=$this->repository->show($StockAdjustment);
        return $StockAdjustment?
            ApiResponse::withOk('Stock Adjustment Found',new StockAdjustmentResource($StockAdjustment))
            : ApiResponse::withNotFound('Stock Adjustment Not Found');
    }

    public function store(StockAdjustmentRequest $StockAdjustmentRequest){
        DB::beginTransaction();
        try{
            $products = $StockAdjustmentRequest['products']??null;
            unset($StockAdjustmentRequest['products']);
            $requestData=$StockAdjustmentRequest->all();
            $StockAdjustment=$this->repository->store($requestData);
            $StockAdjustment = $StockAdjustment->refresh();
            $productsRepo = new RepositoryEloquent(new StockAdjustmentProduct);
            foreach ($products as $product) {
                $product['reference_number'] = $StockAdjustment->reference_number??$StockAdjustment['reference_number']??null;
                $productsRepo->store($products);
            }
            DB::commit();
            return ApiResponse::withOk('Stock Adjustment created',new StockAdjustmentResource($StockAdjustment));
        }
        catch(Exception $e){
            DB::rollBack();
            return ApiResponse::withException($e);
        }
    }

    public function approve(StockAdjustmentApprovalRequest $StockAdjustmentRequest){
        $StockAdjustment = $StockAdjustmentRequest['stock_adjustment_id']??null;
        unset($StockAdjustmentRequest['stock_adjustment_id']);

        $StockAdjustmentRequest['approved_by'] = Auth::id();

        $products = $StockAdjustmentRequest['products']??null;
        unset($StockAdjustmentRequest['products']);

        DB::beginTransaction();
        try{
            $productsRepo = new RepositoryEloquent(new StockAdjustmentProduct);
            foreach ($products as $product) {
                $product['reference_number'] = $StockAdjustment->reference_number??$StockAdjustment['reference_number']??null;
                $stock_adjustment_product_id = $product['id'];
                unset($product['id']);
                $productsRepo->update($products, $stock_adjustment_product_id);
            }
            $StockAdjustment=$this->repository->update($StockAdjustmentRequest->all(),$StockAdjustment);
            DB::commit();
            return ApiResponse::withOk('Stock Adjustment Approved Successfully',new StockAdjustmentResource($StockAdjustment));
        }
        catch(Exception $e){
            DB::rollBack();
            return ApiResponse::withException($e);
        }
    }

    public function getApprovals($status='APPROVED'){
        $searchParams = \request()->query();
        $status = $status??'APPROVED';
        unset($searchParams['status']);

        //DB::enableQueryLog();
        $this->repository->setModel(StockAdjustment::findBy($searchParams)->where(function ($query) use ($status) {
            $query->whereDate('status', $status);
        }));

        $records= $this->repository->getModel()->get();
        //return [DB::getQueryLog()];
        return ApiResponse::withOk('Stock Adjustment Approvals List', StockAdjustmentResource::collection($records));
    }

    public function update(StockAdjustmentRequest $StockAdjustmentRequest,$StockAdjustment){
        try{
            $StockAdjustment=$this->repository->update($StockAdjustmentRequest->all(),$StockAdjustment);
            return ApiResponse::withOk('Stock Adjustment updated',new StockAdjustmentResource($StockAdjustment));
        }
        catch(Exception $e){
            return ApiResponse::withException($e);
        }
    }
    public function destroy($id)
    {
        $this->repository->delete($id);
        return ApiResponse::withOk('Stock Adjustment deleted successfully');
    }
}
