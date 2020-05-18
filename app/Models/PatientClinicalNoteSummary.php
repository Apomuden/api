<?php

namespace App\Models;

use App\Http\Traits\Eloquent\ActiveTrait;
use App\Http\Traits\Eloquent\FindByTrait;
use App\Http\Traits\Eloquent\SortableTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PatientClinicalNoteSummary extends Model
{
    use ActiveTrait, FindByTrait, SortableTrait, SoftDeletes;
    protected $guarded = [];
}
