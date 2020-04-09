<?php

namespace App\Models;

use App\Http\Helpers\DateHelper;
use App\Http\Traits\ActiveTrait;
use App\Http\Traits\FindByTrait;
use App\Repositories\RepositoryEloquent;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Diagnosis extends Model
{
    use ActiveTrait, FindByTrait, SoftDeletes;
    protected $guarded = [];


    public static function boot()
    {
        parent::boot();
        static::creating(function($model){
            $consultation = Consultation::findOrFail($model->consultation_id);
            $model->age = $consultation->age;
            $model->gender = $consultation->patient->gender;
            $model->patient_id = $consultation->patient_id;

            $model->patient_status = $model->patient_status ?? $consultation->patient_status;
            $model->funding_type_id = $model->funding_type_id ?? $consultation->funding_type_id;
            $model->sponsorship_type_id = $model->sponsorship_type_id ?? $consultation->sponsorship_type_id;
            $model->billing_sponsor_id = $model->billing_sponsor_id ?? $consultation->billing_sponsor_id;
            $model->consultant_id = $model->consultant_id ?? $consultation->consultant_id;
            $model->clinic_type_id = $model->clinic_type_id ?? $consultation->clinic_type_id;
            $model->clinic_id = $model->clinic_id ?? $consultation->clinic_id;
            $model->consultation_date = $model->consultation_date ?? ($consultation->started_at ?? Carbon::today());
            $model->attendance_date = $model->attendance_date ?? $consultation->attendance_date;
            $model->user_id = Auth::guard('api')->user()->id;

            $disease=Disease::findOrFail($model->disease_id);
            $model->disease_code=$disease->disease_code;
            $model->icd10_code=$disease->icd10_code;
            $model->icd10_grouping_code=$disease->icd10_grouping_code;
            $model->moh_grouping_code=$disease->moh_grouping_code;
            $model->illness_type_id=$disease->illness_type_id;
            $model->moh_ghs_grouping_id=$disease->moh_ghs_grouping_id;
            $model->icd10_category_id=$disease->icd10_category_id;
            $model->icd10_grouping_id=$disease->icd10_grouping_id;

            $model->age_group_id=$consultation->age_group_id;

         if($consultation->sponsorship_type->name== 'Government Insurance'){
             $model->adult_gdrg=$model->age >12 ?$disease->adult_gdrg:0.00;
             $model->child_gdrg= $model->age < 12 ?$disease->child_gdrg:0.00;

             $model->adult_tariff = $model->age > 12 ? $disease->adult_tariff : 0.00;
             $model->child_gdrg = $model->age > 12 ? $disease->child_gdrg : 0.00;
         }

        });

        static::updating(function ($model) {

        });
    }
    public function disease()
    {
        return $this->belongsTo(Disease::class);
    }

    public function icd10_grouping()
    {
        return $this->belongsTo(Icd10Grouping::class);
    }

    public function icd10_category()
    {
        return $this->belongsTo(Icd10Category::class);
    }

    public function moh_ghs_grouping()
    {
        return $this->belongsTo(MohGhsGrouping::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
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



    public function funding_type()
    {
        return $this->belongsTo(FundingType::class);
    }

    public function sponsorship_type()
    {
        return $this->belongsTo(SponsorshipType::class);
    }

    public function age_group()
    {
        return $this->belongsTo(AgeGroup::class, 'age_group_id');
    }

    public function billing_sponsor()
    {
        return $this->belongsTo(BillingSponsor::class);
    }

    public function patient_sponsor()
    {
        return $this->belongsTo(PatientSponsor::class);
    }

    public function consultant()
    {
        return $this->belongsTo(User::class, 'consultant_id');
    }
}
