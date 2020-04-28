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

class TransactionController extends Controller
{
    private $repository;

    public function __construct()
    {
        $this->repository = new Transaction;
    }

    public function quickDetails($patient_id)
    {
        $repo = $this->repository->buildTransactionDetails($patient_id);
        return ApiResponse::withOk('Quick Transaction Details', new TransactionResource($repo));
    }

    public function createReceipt(TransactionRequest $transactionRequest)
    {
        $receiptItems = $transactionRequest['services']??null;
        if ($receiptItems) {
            $receipt = $transactionRequest->only(['patient_id','patient_status','amount_paid','outstanding_bill','total_bill']);
            $receipt = Ereceipt::createReceipt($receipt);
            foreach ($receiptItems as $item) {
                $itemDetails = explode('::',$item->transaction_update_id);
                $item_type = $itemDetails[0]??null;
                $item_id = $itemDetails[1]??null;
                if ($item_type) {
                    $repo = new RepositoryEloquent(new $item_type);
                    $repo->update(['status'=>($item['status']??null)], $item_id);
                }
                else {
                    continue;
                }
                $receiptItem = new ReceiptItem;
                $receiptItem->ereceipt_id = $receipt['receipt_id'] ?? null;
                $receiptItem->receipt_item_id = $item_id;
                $receiptItem->receipt_item_type = 'App\\Models\\'.$item_type;
                $receiptItem->save();
            }

            $Abscond = Abscond::query()->where('patient_id', $transactionRequest['patient_id']);
            $Abscond->status = 'INACTIVE';
            $Abscond->save();

            $Discount = Discount::query()->where('patient_id', $transactionRequest['patient_id']);
            $Discount->status = 'INACTIVE';
            $Discount->save();

            $Deposit = Deposit::query()->where('patient_id', $transactionRequest['patient_id']);
            $Deposit->status = 'INACTIVE';
            $Deposit->save();

            $repo = new RepositoryEloquent(new Ereceipt);
            $repo = $repo->show($receipt['receipt_id']??null);
            return ApiResponse::withOk('Patient E-Receipt Created', new EreceiptResource($repo));
        }
    }

}
