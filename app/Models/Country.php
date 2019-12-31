<?php

namespace App\Models;

use App\Http\Traits\ActiveTrait;
use App\Http\Traits\FindByTrait;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use ActiveTrait,FindByTrait;
    protected $guarded = [];

    public function regions()
    {
        return $this->hasMany(Region::class);
    }

    public function users()
    {
        return $this->hasMany(Country::class,'origin_country_id');
    }
}
