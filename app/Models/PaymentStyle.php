<?php

namespace App\Models;

use App\Http\Traits\ActiveTrait;
use Illuminate\Database\Eloquent\Model;

class PaymentStyle extends Model
{
    use ActiveTrait;
    protected $guarded = [];

    public function funding_type()
    {
        return $this->hasMany(FundingType::class);
    }

    public function patients()
    {
        return $this->hasMany(Patient::class);
    }
}
