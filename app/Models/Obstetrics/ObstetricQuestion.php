<?php

namespace App\Models\Obstetrics;

use App\Http\Traits\Eloquent\ActiveTrait;
use App\Http\Traits\Eloquent\FindByTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @method static updateOrCreate(array $array, array $param)
 * @method static findOrFail($patient_id)
 */
class ObstetricQuestion extends Model
{
    use ActiveTrait,FindByTrait,SoftDeletes;
    protected $guarded = [];

}
