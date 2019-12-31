<?php

namespace App\Models;

use App\Http\Traits\ActiveTrait;
use App\Http\Traits\FindByTrait;
use Illuminate\Database\Eloquent\Model;

class ServiceCategory extends Model
{
    use ActiveTrait,FindByTrait;
    protected $guarded = [];

    public function hospital_service()
    {
        return $this->belongsTo(HospitalService::class);
    }

    public function service_subcategories()
    {
        return $this->hasMany(ServiceSubcategory::class);
    }
}
