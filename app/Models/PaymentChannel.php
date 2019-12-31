<?php

namespace App\Models;

use App\Http\Traits\ActiveTrait;
use App\Http\Traits\FindByTrait;
use Illuminate\Database\Eloquent\Model;

class PaymentChannel extends Model
{
    use ActiveTrait,FindByTrait;
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
