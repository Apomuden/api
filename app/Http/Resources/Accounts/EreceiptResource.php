<?php

namespace App\Http\Resources\Accounts;

use App\Http\Helpers\DateHelper;
use Illuminate\Http\Resources\Json\JsonResource;

class EreceiptResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $receipt_items = [];
        $service_orders = $this->service_order ?? [];
        $deposits = $this->deposit ?? [];
        foreach ($service_orders as $service_order) {
            $receipt_items[] = [
                'id' => $service_order->pivot->id,
                'description' => $service_order->service->description ?? null,
                'item_fee' => $service_order->service_fee ?? null,
                'item_quantity' => $service_order->service_quantity ?? null,
                'item_total_amt' => $service_order->service_total_amt ?? null,
                'prepaid' => boolval($service_order->prepaid) ? 'YES' : 'NO',
                'insured' => boolval($service_order->insured) ? 'YES' : 'NO',
                'item_bill' => (!$service_order->prepaid && $service_order->insured) ? 0.00 : $service_order->service_total_amt,
                //'item_paid'=>boolval($service_order->pivot->paid??null)
            ];
        }
        foreach ($deposits as $deposit) {
            $receipt_items[] = [
                'item_id' => $deposit->pivot->id ?? null,
                'description' => 'Deposit' ?? null,
                'item_fee' => null,
                'item_quantity' => null,
                'item_total_amt' => $deposit->deposit_amount ?? null,
                //'prepaid'=>boolval($service_order->prepaid),
                //'insured'=>boolval($service_order->insured),
                'item_bill' => $deposit->deposit_amount ?? null,
                //'paid'=>$deposit->pivot->paid?'YES':'NO'
            ];
        }
        return [
            'id' => $this->id,
            'patient_id' => $this->patient_id,
            'patient_status' => $this->patient_status,
            'receipt_items' => $receipt_items,
            'previous_bill' => $this->previous_bill,
            'total_bill' => $this->total_bill,
            'amount_paid' => $this->amount_paid,
            'balance' => $this->balance,
            'invoice_number' => $this->invoice_number,
            'receipt_number' => $this->receipt_number,
            'payment_channel_id' => $this->payment_channel_id??null,
            'payment_channel_name' => $this->payment_channel->name??null,
            'payee_transaction_id' => $this->payee_transaction_id??null,
            'payee_account_no' => $this->payee_account_no ?? null,
            'api_internal_ref' => $this->api_internal_ref ?? null,
            'cheque_no' => $this->cheque_no ?? null,
            'bank_id' => $this->bank_id ?? null,
            'bank_name' => $this->bank->name ?? null,
            'status'=>$this->status??null,
            'created_at' => DateHelper::toDisplayDateTime($this->created_at),
            'updated_at' => DateHelper::toDisplayDateTime($this->updated_at)
        ];
    }
}
