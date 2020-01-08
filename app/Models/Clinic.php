<?php

namespace App\Models;

use App\Http\Traits\ActiveTrait;
use App\Http\Traits\FindByTrait;
use App\Http\Traits\SortableTrait;
use Illuminate\Database\Eloquent\Model;

class Clinic extends Model
{
    use FindByTrait;
    protected $guarded = [];

    public function service_prices()
    {
        return $this->belongsTo(ServicePrice::class);
    }

    public function hospital_services()
    {
        return $this->belongsTo(HospitalService::class);
    }
}
