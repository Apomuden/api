<?php

namespace App\Models;

use App\Http\Traits\ActiveTrait;
use Illuminate\Database\Eloquent\Model;

class SponsorshipType extends Model
{
    use ActiveTrait;
    protected $guarded = [];

    public function funding_types()
    {
        return $this->hasMany(FundingType::class);
    }
}
