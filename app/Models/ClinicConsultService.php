<?php

namespace App\Models;

use App\Http\Traits\ActiveTrait;
use App\Http\Traits\FindByTrait;
use App\Http\Traits\SortableTrait;
use Illuminate\Database\Eloquent\Model;

class ClinicConsultService extends Model
{
    use ActiveTrait, FindByTrait, SortableTrait;
    protected $guarded = [];

    public function service_category()
    {
        return $this->belongsTo(ServiceCategory::class);
    }

    public function billing_cycle()
    {
        return $this->belongsTo(BillingCycle::class);
    }

    public function clinic()
    {
        return $this->belongsTo(Clinic::class);
    }
}
