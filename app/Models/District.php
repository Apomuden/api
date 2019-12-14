<?php

namespace App\Models;

use App\Http\Traits\ActiveTrait;
use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    use ActiveTrait;
    protected $guarded = [];

    public function region()
    {
        return $this->belongsTo(Region::class);
    }

    public function patients()
    {
        return $this->hasMany(Patient::class);
    }

    public function towns()
    {
        return $this->hasMany(Town::class);
    }
}
