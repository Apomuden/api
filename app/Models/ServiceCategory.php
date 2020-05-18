<?php

namespace App\Models;

use App\Http\Traits\Eloquent\ActiveTrait;
use App\Http\Traits\Eloquent\FindByTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ServiceCategory extends Model
{
    use ActiveTrait, FindByTrait, SoftDeletes;
    protected $guarded = [];

    public function hospital_service()
    {
        return $this->belongsTo(HospitalService::class);
    }

    public function service_subcategories()
    {
        return $this->hasMany(ServiceSubcategory::class);
    }

    public function clinic_consult_service()
    {
        return $this->hasMany(Service::class);
    }
}
