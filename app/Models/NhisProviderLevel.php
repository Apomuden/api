<?php

namespace App\Models;

use App\Http\Traits\Eloquent\ActiveTrait;
use App\Http\Traits\Eloquent\FindByTrait;
use App\Http\Traits\Eloquent\SortableTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NhisProviderLevel extends Model
{
    use ActiveTrait, SortableTrait, FindByTrait, SoftDeletes;
    protected $guarded = [];
}
