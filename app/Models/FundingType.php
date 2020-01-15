<?php

namespace App\Models;

use App\Http\Traits\ActiveTrait;
use App\Http\Traits\FindByTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FundingType extends Model
{
    use ActiveTrait,FindByTrait,SoftDeletes;
    protected $guarded = [];

    public function patients()
    {
        return $this->hasMany(Patient::class);
    }

    public function sponsorship_type()
    {
        return $this->belongsTo(SponsorshipType::class);
    }

    public function billing_system()
    {
        return $this->belongsTo(BillingSystem::class);
    }

    public function billing_cycle()
    {
        return $this->belongsTo(BillingCycle::class);
    }

    public function payment_style()
    {
        return $this->belongsTo(PaymentStyle::class);
    }

    public function payment_channel()
    {
        return $this->belongsTo(PaymentChannel::class);
    }
}
