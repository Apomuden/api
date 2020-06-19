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

    // public function comments()
    // {
    //     return $this->hasMany('App\Comment', 'foreign_key', 'local_key');
    // }

    public function nhis_provider_level_tariffs()
    {
        return $this->hasMany(NhisProviderLevelTariff::class);
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
            if($model->age_group->age_name=='ALL')
            $model->tariff_type='CHILD,ADULT';
            else
            $model->tariff_type= $model->age_group->age_name;
        });

        static::created(function($model){
            foreach (request('nhis_provider_levels') as $level) {
                $payload = [
                    'nhis_gdrg_service_tariff_id' => $model->id,
                    'nhis_provider_level_id' => $level['nhis_provider_level_id'],
                    'tariff' => $level['tariff']
                ];

                NhisProviderLevelTariff::updateOrCreate([
                    'nhis_gdrg_service_tariff_id' => $model->id,
                    'nhis_provider_level_id' => $level['nhis_provider_level_id']
                ], $payload);
            }
        });

        static::updating(function($model){
             if($model->isDirty('major_diagnostic_category_id')){
                $model->mdc_code = $model->major_diagnostic_category->mdc_code;
                $model->hospital_service_id = $model->major_diagnostic_category->hospital_service_id;
                $model->patient_status = $model->major_diagnostic_category->patient_status;
                $model->gender =$model->major_diagnostic_category->gender;
                // $model->age_group_id =$model->major_diagnostic_category->age_group_id;
             }

             if($model->isDirty('age_group_id'))
               {
                if ($model->age_group->age_name == 'ALL')
                $model->tariff_type = 'CHILD,ADULT';
                else
                $model->tariff_type = $model->age_group->age_name;
               }

            foreach (request('nhis_provider_levels') as $level) {
                $payload = [
                    'nhis_gdrg_service_tariff_id' => $model->id,
                    'nhis_provider_level_id' => $level['nhis_provider_level_id'],
                    'tariff' => $level['tariff']
                ];

                NhisProviderLevelTariff::updateOrCreate([
                    'nhis_gdrg_service_tariff_id' => $model->id,
                    'nhis_provider_level_id' => $level['nhis_provider_level_id']
                ], $payload);
            }
        });
    }
}
