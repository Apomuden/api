<?php

namespace App\Models;

use App\Http\Traits\Eloquent\ActiveTrait;
use App\Http\Traits\Eloquent\FindByTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Ereceipt extends Model
{
    use ActiveTrait, FindByTrait, SoftDeletes;

    protected $guarded = ['id'];

    public static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->amount_paid = $model->amount_paid ?? $model->total_bill ?? 0;
            $model->balance = ($model->total_bill ?? 0.00) - $model->amount_paid;
        });

        static::updating(function ($model) {
            $model->amount_paid = (($model->amount_paid ?? $model->getOriginal('amount_paid')) ?? $model->total_bill) ?? 0;
            $model->balance = ($model->total_bill ?? 0.00) - $model->amount_paid;
        });
    }

    public static function getLastReceipt($columns = '')
    {
        return Ereceipt::all($columns)->last() ?? null;
    }

    public static function generateReceiptNumber(): string
    {
        $prefix = strtoupper(date('M')) . ' ';
        $midNumber = '00001';
        $postfix = strtoupper(date('y'));
        $receiptNumber = $prefix . '/' . $midNumber . '/' . $postfix;
        $previousReceiptNumber = self::getLastReceipt('receipt_number')->receipt_number ?? null;
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

    public static function createReceipt($model): array
    {
        $model['receipt_number'] = self::generateReceiptNumber();
        $model['user_id'] = Auth::id();
        //dd($model);
        $ereceipt_id = (self::query()->create($model))->id;
        //dd($ereceipt_id);
        return ['ereceipt_id' => $ereceipt_id, 'receipt_number' => $model['receipt_number']];
    }

    public function service_order()
    {
        return $this->morphedByMany(ServiceOrder::class, 'receipt_item');
    }

    public function deposit()
    {
        return $this->morphedByMany(Deposit::class, 'receipt_item')->withPivot(['paid', 'id']);
    }
}
