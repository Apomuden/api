<?php

namespace App\Models;

use App\Http\Traits\Eloquent\ActiveTrait;
use App\Http\Traits\Eloquent\FindByTrait;
use App\Http\Traits\Eloquent\SortableTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Appointment extends AuditableModel
{
    use SoftDeletes;
    use ActiveTrait;
    use SortableTrait;
    use FindByTrait;

    protected $guarded = [];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function clinic()
    {
        return $this->belongsTo(Clinic::class);
    }


    public function doctor()
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }

    public function entry_user()
    {
        return $this->belongsTo(User::class, 'entered_by');
    }

    public function clinic_type()
    {
        return $this->belongsTo(ClinicType::class, 'clinic_type_id');
    }

    public function staff_specialty()
    {
        return $this->belongsTo(StaffSpecialty::class, 'staff_specialty_id');
    }
}
