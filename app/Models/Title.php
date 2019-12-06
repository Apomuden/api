<?php

namespace App\Models;

use App\Http\Traits\ActiveTrait;
use Illuminate\Database\Eloquent\Model;

class Title extends Model
{
    use ActiveTrait;
    protected $guarded = [];
}
