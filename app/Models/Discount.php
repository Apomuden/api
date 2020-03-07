<?php

namespace App\Models;

use App\Http\Traits\ActiveTrait;
use App\Http\Traits\FindByTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Discount extends Model
{
    use ActiveTrait,FindByTrait,SoftDeletes;

    protected $guarded = [];

    public function funding_type() {
        return $this->belongsTo(FundingType::class);
    }

    public function sponsorship_type() {
        return $this->belongsTo(SponsorshipPolicy::class);
    }

    public function patient_sponsor() {
        return $this->belongsTo(PatientSponsor::class);
    }

    public function billing_sponsor() {
        return $this->belongsTo(BillingSponsor::class);
    }
}
