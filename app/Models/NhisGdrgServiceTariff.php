<?php

namespace App\Models;

use App\Http\Traits\Eloquent\ActiveTrait;
use App\Http\Traits\Eloquent\FindByTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NhisGdrgServiceTariff extends Model
{
    use ActiveTrait, FindByTrait, SoftDeletes;
    protected $guarded = [];

    public function hospital_service()
    {
        return $this->belongsTo(HospitalService::class);
    }

    public function age_group()
    {
        return $this->belongsTo(AgeGroup::class);
    }

    public function major_diagnostic_category()
    {
        return $this->belongsTo(MajorDiagnosticCategory::class);
    }
    public function nhis_provider_level()
    {
        return $this->belongsTo(NhisProviderLevel::class);
    }

    public static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->mdc_code=$model->major_diagnostic_category->mdc_code;
            $model->hospital_service_id=$model->major_diagnostic_category->hospital_service_id;
            $model->patient_status=$model->patient_status??$model->major_diagnostic_category->patient_status;
            $model->gender=$model->gender??$model->major_diagnostic_category->gender;
            $model->age_group_id=$model->age_group_id??$model->major_diagnostic_category->age_group_id;
        });

        static::updating(function($model){
             if($model->isDirty('major_diagnostic_category_id')){
                $model->mdc_code = $model->major_diagnostic_category->mdc_code;
                $model->hospital_service_id = $model->major_diagnostic_category->hospital_service_id;
                $model->patient_status = $model->major_diagnostic_category->patient_status;
                $model->gender =$model->major_diagnostic_category->gender;
                $model->age_group_id =$model->major_diagnostic_category->age_group_id;
             }
        });
    }
}
