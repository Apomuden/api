<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Http\Traits\Eloquent\ActiveTrait;
use App\Http\Traits\Eloquent\FindByTrait;
use App\Http\Traits\Eloquent\SortableTrait;
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
            $patient = Patient::findOrFail($model->patient_id);
            $model->funding_type_id = $patient->funding_type_id;
            $model->sponsorship_type_id = $patient->sponsorship_type_id;
            $model->age = $patient->age;
            $model->gender = $patient->gender;
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

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
