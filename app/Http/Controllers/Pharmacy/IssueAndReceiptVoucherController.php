<?php

namespace App\Http\Controllers\Pharmacy;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiResponse;
use App\Http\Requests\Pharmacy\IssueAndReceiptVoucherRequest; //TODO: Make Sure to change to the correct Request namespace
use App\Http\Resources\Pharmacy\IssueAndReceiptVoucherCollection; //TODO: Make Sure to change to the correct Collection namespace
use App\Http\Resources\Pharmacy\IssueAndReceiptVoucherResource; //TODO: Make Sure to change to the correct Resource namespace
use App\Models\IssueAndReceiptVoucher; //TODO: Make Sure to change to the correct Model namespace
use App\Repositories\RepositoryEloquent;
use Exception;
use Illuminate\Http\Request;

class IssueAndReceiptVoucherController extends Controller
{
    protected $repository;

    public function __construct(IssueAndReceiptVoucher $IssueAndReceiptVoucher)
    {
        $this->repository = new RepositoryEloquent($IssueAndReceiptVoucher);
    }

    public function index()
    {
        $paginate = trim(\request()->request->get('paginate'));

        $paginate = $paginate == 'false' ? false : true;
        \request()->request->remove('paginate');
        return ApiResponse::withPaginate(new IssueAndReceiptVoucherCollection(
            $this->repository->all('name'),
            'Issue And Receipt Vouchers list',
            $paginate
        ));
    }

    public function show($IssueAndReceiptVoucher)
    {
        $IssueAndReceiptVoucher = $this->repository->show($IssueAndReceiptVoucher);
        return $IssueAndReceiptVoucher ?
            ApiResponse::withOk(
                'Issue And Receipt Voucher Found',
                new IssueAndReceiptVoucherResource($IssueAndReceiptVoucher)
            )
            : ApiResponse::withNotFound('Issue And Receipt Voucher Not Found');
    }

    public function store(IssueAndReceiptVoucherRequest $IssueAndReceiptVoucherRequest)
    {
        try {
            $requestData = $IssueAndReceiptVoucherRequest->all();
            $IssueAndReceiptVoucher = $this->repository->store($requestData);
            return ApiResponse::withOk(
                'Issue And Receipt Voucher created',
                new IssueAndReceiptVoucherResource($IssueAndReceiptVoucher->refresh())
            );
        } catch (Exception $e) {
            return ApiResponse::withException($e);
        }
    }

    public function update(IssueAndReceiptVoucherRequest $IssueAndReceiptVoucherRequest, $IssueAndReceiptVoucher)
    {
        try {
            $IssueAndReceiptVoucher = $this->repository->update($IssueAndReceiptVoucherRequest->all(), $IssueAndReceiptVoucher);
            return ApiResponse::withOk(
                'Issue And Receipt Voucher updated',
                new IssueAndReceiptVoucherResource($IssueAndReceiptVoucher)
            );
        } catch (Exception $e) {
            return ApiResponse::withException($e);
        }
    }

    public function destroy($id)
    {
        $this->repository->delete($id);
        return ApiResponse::withOk('Issue And Receipt Voucher deleted successfully');
    }
}
