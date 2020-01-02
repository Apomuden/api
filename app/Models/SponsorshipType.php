<?php

namespace App\Models;

use App\Http\Traits\ActiveTrait;
use App\Http\Traits\FindByTrait;
use Illuminate\Database\Eloquent\Model;

class SponsorshipType extends Model
{
    use ActiveTrait,FindByTrait;
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
