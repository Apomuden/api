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
        //static::creating(function ($model) {
        //});
    }

    public function patient_sponsor() {
        return $this->belongsTo(PatientSponsor::class);
    }

    public function billing_sponsor() {
        return $this->belongsTo(BillingSponsor::class);
    }
}
