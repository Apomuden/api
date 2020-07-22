<?php

namespace App\Models\Obstetrics;

use App\Http\Traits\Eloquent\ActiveTrait;
use App\Http\Traits\Eloquent\FindByTrait;
use App\Models\AuditableModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ObsBirthPlace extends AuditableModel
{
    use ActiveTrait,FindByTrait,SoftDeletes;
    protected $guarded = [];

}
