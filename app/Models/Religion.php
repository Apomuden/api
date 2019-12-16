<?php

namespace App\Models;

use App\Http\Traits\ActiveTrait;
use Illuminate\Database\Eloquent\Model;

class Religion extends Model
{
    use ActiveTrait;
    protected $guarded = [];
}
