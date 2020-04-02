<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Http\Traits\ActiveTrait;
use App\Http\Traits\FindByTrait;
use App\Http\Traits\SortableTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class PatientHistoriesSummary extends Model
{
    use ActiveTrait, FindByTrait, SortableTrait, SoftDeletes;
    protected $guarded = [];

    public static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $consultation = Consultation::findOrFail($model->consultation_id);
            $model->age = $consultation->patient->age;
            $model->gender = $consultation->patient->gender;

            $model->patient_status = $model->patient_status ?? $consultation->patient_status;
            $model->funding_type_id = $model->funding_type_id ?? $consultation->funding_type_id;
            $model->sponsorship_type_id = $model->sponsorship_type_id ?? $consultation->sponsorship_type_id;
            $model->billing_sponsor_id = $model->billing_sponsor_id ?? $consultation->billing_sponsor_id;

            $model->user_id = Auth::guard('api')->user()->id;
        });
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }


    public function funding_type()
    {
        return $this->belongsTo(FundingType::class);
    }

    public function sponsorship_type()
    {
        return $this->belongsTo(SponsorshipType::class);
    }


    public function billing_sponsor()
    {
        return $this->belongsTo(BillingSponsor::class);
    }


    public function user()
    {
        return $this->belongsTo(User::class);
    }


}
