<?php

namespace App\Models;

use App\Http\Traits\ActiveTrait;
use App\Http\Traits\FindByTrait;
use App\Http\Traits\SortableTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Appointment extends Model
{
    use SoftDeletes, ActiveTrait, SortableTrait, FindByTrait;
    protected $guarded = [];

    public function patient() {
        return $this->belongsTo(Patient::class);
    }

    public function clinic() {
        return $this->belongsTo(Clinic::class);
    }


    public function doctor() {
        return $this->belongsTo(User::class, 'doctor_id');
    }

    public function entry_user() {
        return $this->belongsTo(User::class, 'entered_by');
    }

    public function clinic_type() {
        return $this->belongsTo(ClinicType::class, 'clinic_type_id');
    }
}
