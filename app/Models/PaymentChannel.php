<?php

namespace App\Models;

use App\Http\Traits\Eloquent\ActiveTrait;
use App\Http\Traits\Eloquent\FindByTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PaymentChannel extends AuditableModel
{
    use ActiveTrait, FindByTrait, SoftDeletes;
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
