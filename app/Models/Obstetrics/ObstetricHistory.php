<?php

namespace App\Models\Obstetrics;

use App\Http\Traits\Eloquent\ActiveTrait;
use App\Http\Traits\Eloquent\FindByTrait;
use App\Models\Consultation;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class ObstetricHistory extends Model
{
    use ActiveTrait, FindByTrait, SoftDeletes;

    protected $guarded = [];

    public static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $patient = Patient::findOrFail($model->patient_id);
            $model->patient_age = $patient->age;
            $model->user_id = Auth::guard('api')->user()->id;
        });
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function consultation()
    {
        return $this->belongsTo(Consultation::class);
    }
}
