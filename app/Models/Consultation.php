<?php

namespace App\Models;

use App\Http\Traits\ActiveTrait;
use App\Http\Traits\FindByTrait;
use App\Http\Traits\SortableTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Consultation extends Model
{
    use SoftDeletes, ActiveTrait, FindByTrait, SortableTrait;
    protected $guarded = [];

    public function clinic_consult_service()
    {
        return $this->belongsTo(ClinicConsultService::class);
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function funding_type()
    {
        return $this->belongsTo(FundingType::class);
    }

    public function sponsorship_type()
    {
        return $this->belongsTo(SponsorshipType::class);
    }

    public function age_group()
    {
        return $this->belongsTo(AgeGroup::class);
    }

    public function billing_sponsor()
    {
        return $this->belongsTo(BillingSponsor::class);
    }

}
