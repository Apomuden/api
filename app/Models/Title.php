<?php

namespace App\Models;

use App\Http\Traits\ActiveTrait;
use App\Http\Traits\FindByTrait;
use App\Http\Traits\SortableTrait;
use Illuminate\Database\Eloquent\Model;

class Title extends Model
{
    use ActiveTrait,SortableTrait,FindByTrait;
    protected $guarded = [];
}
