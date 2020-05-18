<?php

namespace App\Models;


use App\Http\Traits\Eloquent\ActiveTrait;
use App\Http\Traits\Eloquent\FindByTrait;
use App\Http\Traits\Eloquent\SortableTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClinicType extends Model
{
    use SoftDeletes, ActiveTrait, FindByTrait, SortableTrait;
    protected $guarded = [];

    public function clinics()
    {
        return $this->hasMany(Clinic::class);
    }
}
