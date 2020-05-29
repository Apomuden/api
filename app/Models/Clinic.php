<?php

namespace App\Models;

use App\Http\Traits\Eloquent\ActiveTrait;
use App\Http\Traits\Eloquent\FindByTrait;
use App\Http\Traits\Eloquent\SortableTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Clinic extends Model
{
    use SoftDeletes, ActiveTrait, FindByTrait, SortableTrait;
    protected $guarded = [];

    public function age_group()
    {
        return $this->belongsTo(AgeGroup::class);
    }


    public function clinic_type()
    {
        return $this->belongsTo(ClinicType::class);
    }
}
