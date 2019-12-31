<?php

namespace App\Models;

use App\Http\Traits\ActiveTrait;
use App\Http\Traits\FindByTrait;
use Illuminate\Database\Eloquent\Model;

class PatientNextOfKin extends Model
{
    use ActiveTrait,FindByTrait;
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}
