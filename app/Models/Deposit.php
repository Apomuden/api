<?php

namespace App\Models;

use App\Http\Traits\ActiveTrait;
use App\Http\Traits\FindByTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use function foo\func;

class Deposit extends Model
{
    use ActiveTrait,FindByTrait,SoftDeletes;

    protected $guarded = [];
    public $receiptItemType = 'deposit';

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $receipt = $model->only(['patient_id','patient_status']);
            $receipt = Ereceipt::createReceipt($receipt);
            //dd($receipt);
            $model->receipt_number = $receipt['receipt_number']??null;
            unset($receipt);
            //dd($model);
        });

        static::created(function ($model) {
            $receiptItem = $model->only(['receipt_number']);
            unset($receiptItem['receipt_number']);
            $receiptItem = new ReceiptItem();
            $receiptItem->ereceipt_id = Ereceipt::getLastReceipt('id')->id??null;
            $receiptItem->receipt_item_id = $model->id;
            $receiptItem->receipt_item_type = get_class($model);
            dd($receiptItem);
            dd($model->ereceipt()->save($receiptItem));
        });
    }

    public function  ereceipt()
    {
        return $this->morphToMany(Ereceipt::class, 'receipt_item');
    }

    public function patient_sponsor() {
        return $this->belongsTo(PatientSponsor::class);
    }

    public function billing_sponsor() {
        return $this->belongsTo(BillingSponsor::class);
    }
}
