<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FundingType extends Model
{
    protected $guarded = [];

    public function patients()
    {
        return $this->hasMany(Patient::class);
    }
}
