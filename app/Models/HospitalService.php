<?php

namespace App\Models;

use App\Http\Traits\ActiveTrait;
use Illuminate\Database\Eloquent\Model;

class HospitalService extends Model
{
    use ActiveTrait;
    protected $guarded = [];

    public function service_categories()
    {
        return $this->hasMany(ServiceCategory::class);
    }
}
