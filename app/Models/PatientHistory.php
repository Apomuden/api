<?php

namespace App\Models;

use App\Http\Traits\FindByTrait;
use App\Http\Traits\SortableTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class PatientHistory extends Model
{
  use FindByTrait,SortableTrait,SoftDeletes;

    public static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
           $consultation=Consultation::findOrFail($model->consultation_id);
           $model->age=$consultation->patient->age;
           $model->gender=$consultation->patient->gender;

           $model->patient_status= $model->patient_status??$consultation->patient_status;
           $model->funding_type_id=$model->funding_type_id??$consultation->funding_type_id;
           $model->sponsorship_type_id=$model->sponsorship_type_id??$consultation->sponsorship_type_id;
           $model->billing_sponsor_id=$model->billing_sponsor_id??$consultation->billing_sponsor_id;
           $model->consultant_id=$model->consultant_id??$consultation->consultant_id;
           $model->clinic_type_id=$model->clinic_type_id??$consultation->clinic_type_id;
           $model->clinic_id=$model->clinic_id??$consultation->clinic_id;
           $model->consultation_date= $model->consultation_date??($consultation->started_at??Carbon::today());
           $model->attendance_date=$model->attendance_date??$consultation->attendance_date;
           $model->user_id = Auth::guard('api')->user()->id;
        });
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


    public function billing_sponsor()
    {
        return $this->belongsTo(BillingSponsor::class);
    }

    public function consultant()
    {
        return $this->belongsTo(User::class, 'consultant_id');
    }

    public function consultation()
    {
        return $this->belongsTo(Consultation::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function chief_complaint_relation()
    {
        return $this->belongsTo(User::class, 'chief_complaint_relation_id');
    }
}