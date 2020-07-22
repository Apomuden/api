<?php

namespace App\Http\Controllers\Pharmacy;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiResponse;
use App\Http\Requests\Pharmacy\RequisitionApprovalRequest;
use App\Http\Requests\Pharmacy\RequisitionRequest; //TODO: Make Sure to change to the correct Request namespace
use App\Http\Resources\Pharmacy\RequisitionCollection; //TODO: Make Sure to change to the correct Collection namespace
use App\Http\Resources\Pharmacy\RequisitionResource; //TODO: Make Sure to change to the correct Resource namespace
use App\Models\Requisition; //TODO: Make Sure to change to the correct Model namespace
use App\Models\RequisitionProduct;
use App\Repositories\RepositoryEloquent;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RequisitionController extends Controller
{
    protected $repository;

    public function __construct(Requisition $Requisition)
    {
        $this->repository = new RepositoryEloquent($Requisition);
    }

    public function index()
    {
        $paginate = trim(\request()->request->get('paginate'));

        $paginate = $paginate == 'false' ? false : true;
        \request()->request->remove('paginate');
        return ApiResponse::withPaginate(new RequisitionCollection(
            $this->repository->all('name'),
            'Requisitions list',
            $paginate
        ));
    }

    public function show($Requisition)
    {
        $Requisition = $this->repository->show($Requisition);
        return $Requisition ?
            ApiResponse::withOk('Requisition Found', new RequisitionResource($Requisition))
            : ApiResponse::withNotFound('Requisition Not Found');
    }

    public function store(RequisitionRequest $RequisitionRequest)
    {
        $RequisitionRequest['requested_by'] = Auth::id();

        $products = $RequisitionRequest['products'] ?? null;
        unset($RequisitionRequest['products']);

        DB::beginTransaction();
        try {
            $requestData = $RequisitionRequest->all();
            $Requisition = $this->repository->store($requestData);
            $Requisition = $Requisition->refresh();
            $productsRepo = new RepositoryEloquent(new RequisitionProduct());
            foreach ($products as $product) {
                $product['reference_number'] = $Requisition->reference_number ?? $Requisition['reference_number'] ?? null;
                $productsRepo->store($product);
            }
            DB::commit();
            return ApiResponse::withOk('Requisition created', new RequisitionResource($Requisition));
        } catch (Exception $e) {
            DB::rollBack();
            return ApiResponse::withException($e);
        }
    }

    public function approve(RequisitionApprovalRequest $RequisitionRequest)
    {
        $Requisition = $RequisitionRequest['requisition_id'] ?? null;
        unset($RequisitionRequest['requisition_id']);

        $RequisitionRequest['approved_by'] = Auth::id();

        $products = $RequisitionRequest['products'] ?? null;
        unset($RequisitionRequest['products']);

        DB::beginTransaction();
        try {
            $productsRepo = new RepositoryEloquent(new RequisitionProduct());
            $Requisition = $this->repository->update($RequisitionRequest->all(), $Requisition);
            foreach ($products as $product) {
                $product['reference_number'] = $Requisition->reference_number ?? $Requisition['reference_number'] ?? null;
                $requisition_product_id = $product['id'];
                unset($product['id']);
                $productsRepo->update($products, $requisition_product_id);
            }
            DB::commit();
            return ApiResponse::withOk('Requisition Approved Successfully', new RequisitionResource($Requisition));
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
        $this->repository->setModel(Requisition::findBy($searchParams)->where(function ($query) use ($status) {
            $query->where('status', $status);
        }));

        $records = $this->repository->getModel()->get();
        //return [DB::getQueryLog()];
        return ApiResponse::withPaginate(new RequisitionCollection($records, 'Requisition Approvals List', $paginate));
    }

    public function update(RequisitionRequest $RequisitionRequest, $Requisition)
    {
        try {
            $Requisition = $this->repository->update($RequisitionRequest->all(), $Requisition);
            return ApiResponse::withOk('Requisition updated', new RequisitionResource($Requisition));
        } catch (Exception $e) {
            return ApiResponse::withException($e);
        }
    }

    public function destroy($id)
    {
        $this->repository->delete($id);
        return ApiResponse::withOk('Requisition deleted successfully');
    }
}
