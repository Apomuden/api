<?php

namespace App\Models;

use App\Http\Traits\ActiveTrait;
use Illuminate\Database\Eloquent\Model;

class PatientNextOfKin extends Model
{
    use ActiveTrait;
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}
