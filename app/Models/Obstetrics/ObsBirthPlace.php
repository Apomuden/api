<?php

namespace App\Models\Obstetrics;

use App\Http\Traits\Eloquent\ActiveTrait;
use App\Http\Traits\Eloquent\FindByTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ObsBirthPlace extends Model
{
    use ActiveTrait,FindByTrait,SoftDeletes;
    protected $guarded = [];

}
