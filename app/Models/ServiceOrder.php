<?php

namespace App\Models;

use App\Http\Traits\ActiveTrait;
use App\Http\Traits\FindByTrait;
use App\Http\Traits\SortableTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class ServiceOrder extends Model
{
    use ActiveTrait, SortableTrait, FindByTrait, SoftDeletes;
    protected $guarded = [];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function clinic()
    {
        return $this->belongsTo(Clinic::class);
    }

    public function clinic_type()
    {
        return $this->belongsTo(ClinicType::class);
    }

    public function hospital_service()
    {
        return $this->belongsTo(HospitalService::class);
    }

    public function service_category()
    {
        return $this->belongsTo(ServiceCategory::class);
    }

    public function service_subcategory()
    {
        return $this->belongsTo(ServiceSubcategory::class);
    }

    
}
