<?php

namespace App\Models;

use App\Http\Traits\ActiveTrait;
use App\Http\Traits\FindByTrait;
use App\Repositories\RepositoryEloquent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BillingSponsor extends Model
{
    use ActiveTrait,FindByTrait,SoftDeletes;
    protected $guarded = [];

    public function sponsorship_type()
    {
        return $this->belongsTo(SponsorshipType::class);
    }


    public function billing_system()
    {
        return $this->belongsTo(BillingSystem::class, 'billing_system_id');
    }

    public function billing_cycle()
    {
        return $this->belongsTo(BillingCycle::class, 'billing_cycle_id');
    }

    public function payment_style()
    {
        return $this->belongsTo(PaymentStyle::class, 'payment_style_id');
    }

    public function payment_channel()
    {
        return $this->belongsTo(PaymentChannel::class, 'payment_channel_id');
    }

}
