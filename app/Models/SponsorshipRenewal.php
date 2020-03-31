<?php

namespace App\Models;

use App\Http\Traits\ActiveTrait;
use App\Http\Traits\FindByTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SponsorshipRenewal extends Model
{
    use ActiveTrait,FindByTrait,SoftDeletes;
    protected $guarded = [];

    public function user() {
        return $this->belongsTo(User::class, 'renewed_by');
    }

    public function patient() {
        return $this->belongsTo(Patient::class);
    }

    public function billing_sponsor() {
        return $this->belongsTo(BillingSponsor::class);
    }

    public function sponsorship_policy() {
        return $this->belongsTo(SponsorshipPolicy::class);
    }

    public function patient_sponsor() {
        return $this->belongsTo(PatientSponsor::class);
    }
}
