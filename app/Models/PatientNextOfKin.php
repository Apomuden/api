<?php

namespace App\Models;

use App\Http\Traits\ActiveTrait;
use App\Http\Traits\FindByTrait;
use Illuminate\Database\Eloquent\Model;

class PatientNextOfKin extends Model
{
    use ActiveTrait,FindByTrait;
    protected $guarded = [];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function relationship()
    {
        return $this->belongsTo(Relationship::class,'relation_id');
    }
}
