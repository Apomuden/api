<?php

namespace App\Models;

use App\Http\Traits\ActiveTrait;
use App\Http\Traits\FindByTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Refund extends Model
{
    use ActiveTrait,FindByTrait,SoftDeletes;

    protected $guarded = [];

    public static function boot() {
        parent::boot();
        static::creating(function($model){
            $model->receipt_number = $model->receipt_number??null;
            $ereceipt = Ereceipt::query()->find(['receipt_number','total_bill'])->where(['receipt_number'=>$model->receipt_number]);
            $ereceipt = $ereceipt->first()??null;
            $model->total_bill = $model->total_bill??$ereceipt->total_bill??0;
            $model->refund_amount = $model->refund_amount??$model->total_bill??0;
            unset($ereceipt);
        });
    }

    public function funding_type() {
        return $this->belongsTo(FundingType::class);
    }

    public function sponsorship_type() {
        return $this->belongsTo(SponsorshipType::class);
    }

    public function patient_sponsor() {
        return $this->belongsTo(PatientSponsor::class);
    }

    public function billing_sponsor() {
        return $this->belongsTo(BillingSponsor::class);
    }
}
