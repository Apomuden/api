<?php

namespace App\Models;

use App\Http\Traits\Eloquent\ActiveTrait;
use App\Http\Traits\Eloquent\FindByTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SponsorshipType extends AuditableModel
{
    use ActiveTrait, FindByTrait, SoftDeletes;
    protected $guarded = [];

    public function funding_types()
    {
        return $this->hasMany(FundingType::class);
    }

    public function billing_sponsors()
    {
        return $this->hasMany(BillingSponsor::class);
    }
}
