<?php

namespace App\Http\Controllers\Accounts;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiResponse;
use App\Http\Requests\Accounts\TransactionRequest;
use App\Http\Resources\Accounts\EreceiptResource;
use App\Http\Resources\Accounts\TransactionResource;
use App\Models\Abscond;
use App\Models\Deposit;
use App\Models\Discount;
use App\Models\Ereceipt;
use App\Models\ReceiptItem;
use App\Models\Transaction;
use App\Repositories\RepositoryEloquent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    private $repository;

    public function __construct()
    {
        $this->repository = new Transaction();
    }

    public function quickDetails($patient_id)
    {
        $repo = $this->repository->buildTransactionDetails($patient_id);
        return ApiResponse::withOk('Quick Transaction Details', new TransactionResource($repo));
    }

    public function createReceipt(TransactionRequest $transactionRequest)
    {
        $receiptItems = $transactionRequest['services'] ?? null;

        try {
            DB::beginTransaction();
            if ($receiptItems) {
                $receipt = $transactionRequest->only(['patient_id', 'patient_status', 'amount_paid', 'outstanding_bill', 'total_bill']);
                $receipt = Ereceipt::createReceipt($receipt);

                foreach ($receiptItems as $item) {
                    $itemDetails = explode('::', ($item['transaction_update_id'] ?? null));
                    $item_type = $itemDetails[0] ?? null;
                    $item_type = $item_type ? '\\App\\Models\\' . $item_type : null;
                    $item_id = $itemDetails[1] ?? null;

                    $repo = $item_type::query()->find($item_id);
                    $repo->update(['status' => ($item['status'] ?? 'FULL-PAYMENT')]);
                    //dd(get_class($repo));
                    $receiptItem = new ReceiptItem();
                    $receiptItem->ereceipt_id = $receipt['ereceipt_id'] ?? null;
                    $receiptItem->receipt_item_id = $item_id;
                    $receiptItem->receipt_item_type = get_class($repo);
                    $receiptItem->save();
                }

                $Abscond = Abscond::query()->where('patient_id', $transactionRequest['patient_id']);
                $Abscond->update(['status' => 'INACTIVE']);

                $Discount = Discount::query()->where('patient_id', $transactionRequest['patient_id']);
                $Discount->update(['status' => 'INACTIVE']);

                $Deposit = Deposit::query()->where('patient_id', $transactionRequest['patient_id']);
                $Deposit->update(['status' => 'INACTIVE']);
                DB::commit();

                $repo = new RepositoryEloquent(new Ereceipt());
                $repo = $repo->show($receipt['ereceipt_id'] ?? null);
                return ApiResponse::withOk('Patient E-Receipt Created', new EreceiptResource($repo));
            }
        } catch (\Exception $exception) {
            //DB::rollBack();
            dd($exception);
        }
    }
    public function createInvoice(TransactionRequest $transactionRequest)
    {
        $receiptItems = $transactionRequest['services'] ?? null;

            DB::beginTransaction();
            if ($receiptItems) {
                $receipt = $transactionRequest->only(['patient_id', 'patient_status', 'amount_paid', 'outstanding_bill', 'total_bill']);
                $receipt = Ereceipt::createReceipt($receipt,'INVOICE');

                foreach ($receiptItems as $item) {
                    $itemDetails = explode('::', ($item['transaction_update_id'] ?? null));
                    $item_type = $itemDetails[0] ?? null;
                    $item_type = $item_type ? '\\App\\Models\\' . $item_type : null;
                    $item_id = $itemDetails[1] ?? null;

                    $repo = $item_type::query()->find($item_id);

                    if(isset($item['status']) && $item['status'])
                    $repo->update(['status' => ($item['status'] ?? 'FULL-PAYMENT')]);
                    //dd(get_class($repo));
                    $receiptItem = new ReceiptItem();
                    $receiptItem->ereceipt_id = $receipt['ereceipt_id'] ?? null;
                    $receiptItem->receipt_item_id = $item_id;
                    $receiptItem->receipt_item_type = get_class($repo);
                    $receiptItem->save();
                }

                $Abscond = Abscond::query()->where('patient_id', $transactionRequest['patient_id']);
                $Abscond->update(['status' => 'INACTIVE']);

                $Discount = Discount::query()->where('patient_id', $transactionRequest['patient_id']);
                $Discount->update(['status' => 'INACTIVE']);

                $Deposit = Deposit::query()->where('patient_id', $transactionRequest['patient_id']);
                $Deposit->update(['status' => 'INACTIVE']);
                DB::commit();

                $repo = new RepositoryEloquent(new Ereceipt());
                $repo = $repo->show($receipt['ereceipt_id'] ?? null);
                return ApiResponse::withOk('Patient E-Invoice Created', new EreceiptResource($repo));
            }

    }

}
