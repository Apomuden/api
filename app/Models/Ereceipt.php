<?php

namespace App\Models;

use App\Http\Traits\Eloquent\ActiveTrait;
use App\Http\Traits\Eloquent\FindByTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class Ereceipt extends AuditableModel
{
    use ActiveTrait;
    use FindByTrait;
    use SoftDeletes;

    protected $guarded = ['id'];

    public static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->amount_paid = $model->amount_paid ?? $model->total_bill ?? 0;
            $model->balance = ($model->total_bill ?? 0.00) - $model->amount_paid;

        //    if(!$model->payment_channel_id)
        //     $model->payment_channel_id= PaymentChannel::wherePriority(0)->first()->id??null;

        //     if(!$model->cheque_no && in_array(ucwords($model->payment_channel->name),['Bank Interface','Banking Interface','Bank Deposit'])){
        //         if(!$model->bank_id)
        //             $model->bank_id = Bank::wherePriority(0)->first()->id??null;
        //     }
        });

        static::updating(function ($model) {
            $model->amount_paid = (($model->amount_paid ?? $model->getOriginal('amount_paid')) ?? $model->total_bill) ?? 0;
            $model->balance = ($model->total_bill ?? 0.00) - $model->amount_paid;

            if($model->getOriginal('status')!= 'FULL-PAYMENT' && $model->status== 'FULL-PAYMENT')
            $model->receipt_number=self::generateReceiptNumber();

            // if ($model->isDirty('payment_channel_id') && !$model->payment_channel_id)
            // $model->payment_channel_id = PaymentChannel::wherePriority(0)->first()->id ?? null;

            // if ($model->isDirty('payment_channel_id') && !$model->cheque_no && in_array(ucwords($model->payment_channel->name), ['Bank Interface', 'Banking Interface', 'Bank Deposit'])) {
            //     if (!$model->bank_id)
            //         $model->bank_id = Bank::wherePriority(0)->first()->id ?? null;
            // }
        });
    }

    public static function getLastReceipt($columns = '')
    {
        return Ereceipt::all($columns)->last() ?? null;
    }

    public static function generateReceiptNumber($type='RECEIPT'): string
    {
        if($type== 'RECEIPT')
          $prefix='REP';
        else if($type == 'DEPOSIT')
          $prefix='DEP';
        else if($type == 'INVOICE')
          $prefix='INV';

        $prefix =$prefix. strtoupper(date('m'));
        $midNumber = '00001';
        $postfix = strtoupper(date('y'));
        $receiptNumber = $prefix . '/' . $midNumber . '/' . $postfix;
        $previousReceiptNumber = self::getLastReceipt($type== 'INVOICE'?'invoice_number': 'receipt_number')->{($type=='INVOICE'? 'invoice_number': 'receipt_number')} ?? null;
        $previousReceiptNumberArray = $previousReceiptNumber ? explode('/', $previousReceiptNumber) : null;
        if ($previousReceiptNumber) {
            if ($previousReceiptNumberArray[0] == $prefix && $previousReceiptNumberArray[2] == $postfix) {
                $previousReceiptNumberArray[1] = ((int) $previousReceiptNumberArray[1]) + 1;
                if (strlen($previousReceiptNumberArray[1]) < 5) {
                    $previousReceiptNumberArray[1] = str_pad($previousReceiptNumberArray[1], 5, '0', STR_PAD_LEFT);
                }
                $receiptNumber = implode('/', $previousReceiptNumberArray);
            }
        }
        return $receiptNumber;
    }


    public static function createReceipt($model,$type='RECEIPT'): array
    {
        $response = ['ereceipt_id' => null, 'invoice_number' => null, 'receipt_number' => null];

        $field= ($type == 'INVOICE' ? 'invoice_number' : 'receipt_number');
        $model[$field] = self::generateInvoiceNumber($type);

        $response[$field]= $model[$field];

        $model['user_id'] = Auth::id();
        //dd($model);
        $ereceipt_id = (self::query()->create($model))->id;
        $response['ereceipt_id'] = $ereceipt_id;

        //dd($ereceipt_id);
        return $response;
    }

    public function service_order()
    {
        return $this->morphedByMany(ServiceOrder::class, 'receipt_item');
    }

    public function deposit()
    {
        return $this->morphedByMany(Deposit::class, 'receipt_item')->withPivot(['paid', 'id']);
    }

    public function payment_channel()
    {
        return $this->belongsTo(PaymentChannel::class);
    }

    public function bank()
    {
        return $this->belongsTo(Bank::class);
    }
}
