<?php

namespace App\Models;

use App\Http\Traits\Eloquent\ActiveTrait;
use App\Http\Traits\Eloquent\FindByTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PatientNextOfKin extends Model
{
    use ActiveTrait, FindByTrait, SoftDeletes;
    protected $guarded = [];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function relationship()
    {
        return $this->belongsTo(Relationship::class, 'relation_id');
    }
}
