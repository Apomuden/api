<?php

namespace App\Http\Controllers\Pharmacy;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiResponse;
use App\Http\Helpers\DateHelper;
use App\Http\Requests\Pharmacy\StockAdjustmentApprovalRequest;
use App\Http\Requests\Pharmacy\StockAdjustmentRequest;
use App\Http\Resources\Pharmacy\StockAdjustmentCollection;
use App\Http\Resources\Pharmacy\StockAdjustmentResource;
use App\Models\Stock;
use App\Models\StockAdjustment;
use App\Models\StockAdjustmentProduct;
use App\Repositories\RepositoryEloquent;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StockAdjustmentController extends Controller
{
    protected $repository;

    public function __construct(StockAdjustment $StockAdjustment)
    {
        $this->repository = new RepositoryEloquent($StockAdjustment);
    }

    public function index()
    {
        $paginate = trim(\request()->request->get('paginate'));

        $paginate = $paginate == 'false' ? false : true;
        \request()->request->remove('paginate');
        return ApiResponse::withPaginate(new StockAdjustmentCollection(
            $this->repository->all('name'),
            'Stock Adjustments list',
            $paginate
        ));
    }

    public function show($StockAdjustment)
    {
        $StockAdjustment = $this->repository->show($StockAdjustment);
        return $StockAdjustment ?
            ApiResponse::withOk('Stock Adjustment Found', new StockAdjustmentResource($StockAdjustment))
            : ApiResponse::withNotFound('Stock Adjustment Not Found');
    }

    public function store(StockAdjustmentRequest $StockAdjustmentRequest)
    {
        DB::beginTransaction();
        try {
            $products = $StockAdjustmentRequest['products'] ?? null;
            unset($StockAdjustmentRequest['products']);
            $StockAdjustmentRequest['requested_by'] = Auth::id();
            $requestData = $StockAdjustmentRequest->all();
            $StockAdjustment = $this->repository->store($requestData);
            $StockAdjustment = $StockAdjustment->refresh();
            $productsRepo = new RepositoryEloquent(new StockAdjustmentProduct());
            foreach ($products as $product) {
                $product['reference_number'] = $StockAdjustment->reference_number ?? $StockAdjustment['reference_number'] ?? null;
                $productsRepo->store($product);
            }
            DB::commit();
            return ApiResponse::withOk('Stock Adjustment created', new StockAdjustmentResource($StockAdjustment));
        } catch (Exception $e) {
            DB::rollBack();
            return ApiResponse::withException($e);
        }
    }

    public function approve(StockAdjustmentApprovalRequest $StockAdjustmentRequest)
    {
        $StockAdjustment = $StockAdjustmentRequest['stock_adjustment_id'] ?? null;
        unset($StockAdjustmentRequest['stock_adjustment_id']);

        $StockAdjustmentRequest['approved_by'] = Auth::id();
        $StockAdjustmentRequest['approval_date'] = $StockAdjustmentRequest['approval_date']??DateHelper::toDBDateTime(Carbon::now());

        $products = $StockAdjustmentRequest['products'] ?? null;
        unset($StockAdjustmentRequest['products']);

        DB::beginTransaction();
        try {
            $productsRepo = new RepositoryEloquent(new StockAdjustmentProduct());
            $StockAdjustment = $this->repository->update($StockAdjustmentRequest->all(), $StockAdjustment);
            $stock = null;
            $store_id = null;
            $stock_adjustment_product_id = null;
            foreach ($products as $product) {
                $stock_adjustment_product_id = $product['id'];
                unset($product['id']);
                $productsRepo->update($product, $stock_adjustment_product_id);
                $store_id = $StockAdjustment['store_id']??($StockAdjustment->store_id??null);
                $stock = Stock::query()->firstWhere(['product_id'=>$products['product_id'], 'store_id'=>$store_id]);
                if ($stock->count()) {
                    $stock->original_quantity += $products['approved_quantity'];
                    $stock->quantity_remaining += $products['approved_quantity'];
                    $stock->update();
                } else {
                    Stock::query()->firstOrCreate([
                        'product_id' => $products['product_id'],
                        'store_id' => $products['store_id'],
                        'opening_stock_quantity' => $products['approved_quantity'],
                        'original_quantity' => $products['approved_quantity'],
                        'quantity_remaining' => $products['approved_quantity']
                    ]);
                }
            }
            DB::commit();
            return ApiResponse::withOk('Stock Adjustment Approved Successfully', new StockAdjustmentResource($StockAdjustment));
        } catch (Exception $e) {
            DB::rollBack();
            return ApiResponse::withException($e);
        }
    }

    public function getApprovals($status = 'APPROVED')
    {
        $paginate = trim(\request()->request->get('paginate'));

        $paginate = $paginate == 'false' ? false : true;
        \request()->request->remove('paginate');
        $searchParams = \request()->query();
        $status = $status ?? 'APPROVED';
        unset($searchParams['status']);

        //DB::enableQueryLog();
        $this->repository->setModel(StockAdjustment::findBy($searchParams)->where(function ($query) use ($status) {
            $query->where('status', $status);
        }));

        $records = $this->repository->getModel()->get();
        //return [DB::getQueryLog()];
        return ApiResponse::withPaginate(new StockAdjustmentCollection($records, 'Stock Adjustment Approvals List', $paginate));
    }

    public function update(StockAdjustmentRequest $StockAdjustmentRequest, $StockAdjustment)
    {
        try {
            $StockAdjustment = $this->repository->update($StockAdjustmentRequest->all(), $StockAdjustment);
            return ApiResponse::withOk('Stock Adjustment updated', new StockAdjustmentResource($StockAdjustment));
        } catch (Exception $e) {
            return ApiResponse::withException($e);
        }
    }
    public function destroy($id)
    {
        $this->repository->delete($id);
        return ApiResponse::withOk('Stock Adjustment deleted successfully');
    }
}
