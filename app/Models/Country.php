<?php

namespace App\Models;

use App\Http\Traits\Eloquent\ActiveTrait;
use App\Http\Traits\Eloquent\FindByTrait;
use Illuminate\Database\Eloquent\Model;

class Country extends AuditableModel
{
    use ActiveTrait;
    use FindByTrait;

    protected $guarded = [];

    public function regions()
    {
        return $this->hasMany(Region::class);
    }

    public function users()
    {
        return $this->hasMany(Country::class, 'origin_country_id');
    }
}
