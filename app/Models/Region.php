<?php

namespace App\Models;

use App\Http\Traits\Eloquent\ActiveTrait;
use App\Http\Traits\Eloquent\FindByTrait;
use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    use ActiveTrait, FindByTrait;
    protected $guarded = [];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function users()
    {
        return $this->hasMany(User::class, 'origin_region_id');
    }
    public function districts()
    {
        return $this->hasMany(District::class);
    }
}
