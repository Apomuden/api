<?php

namespace App\Models;

use App\Http\Traits\Eloquent\ActiveTrait;
use App\Http\Traits\Eloquent\FindByTrait;
use App\Http\Traits\Eloquent\SortableTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Service extends Model
{
    use ActiveTrait, SortableTrait, FindByTrait, SoftDeletes;

    protected $guarded = [];

    public function getDisplayNameAttribute()
    {
        if ($this->description)
            return $this->description;
        else
            return $this->service_subcategory->name ?? $this->service_category->name;
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

    public function age_group()
    {
        return $this->belongsTo(AgeGroup::class);
    }

    public function lab_parameters()
    {
        return $this->belongsToMany(LabParameter::class, 'lab_service_parameters')->withPivot(['order', 'created_at', 'updated_at']);
    }

    public function lab_sample_types()
    {
        return $this->belongsToMany(LabSampleType::class, 'lab_service_sample_types')->withPivot(['order', 'created_at', 'updated_at']);
    }

    public function consultation_components()
    {
        return $this->belongsToMany(ConsultationComponent::class, 'services_consultation_components')->withPivot(['order', 'created_at', 'updated_at']);
    }

    public function consultation_questions()
    {
        return $this->belongsToMany(ConsultationQuestion::class, 'services_consultation_questions')->withPivot(['order', 'created_at', 'updated_at']);
    }
}
