<?php

namespace App\Models;

use App\Http\Traits\ActiveTrait;
use App\Http\Traits\FindByTrait;
use App\Http\Traits\SortableTrait;
use Illuminate\Database\Eloquent\Model;

class Town extends Model
{
    use ActiveTrait,SortableTrait,FindByTrait;
    protected $guarded = [];

    public function district()
    {
        return $this->belongsTo(District::class);
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function region()
    {
        return $this->belongsTo(Region::class);
    }

    public function patients()
    {
        return $this->hasMany(Patient::class);
    }
}
