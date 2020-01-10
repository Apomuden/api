<?php

namespace App\Models;

use App\Http\Traits\ActiveTrait;
use App\Http\Traits\FindByTrait;
use App\Http\Traits\SortableTrait;
use Illuminate\Database\Eloquent\Model;

class Consultation extends Model
{
    use ActiveTrait, FindByTrait, SortableTrait;
    protected $guarded = [];

    public function clinic()
    {
        return $this->belongsTo(Clinic::class);
    }

    public function service_price()
    {
        return $this->belongsTo(ServicePrice::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}
