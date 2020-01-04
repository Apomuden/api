<?php

namespace App\Models;

use App\Http\Traits\ActiveTrait;
use App\Http\Traits\FindByTrait;
use App\Http\Traits\SortableTrait;
use Illuminate\Database\Eloquent\Model;

class PasswordReset extends Model
{
    use ActiveTrait,FindByTrait,SortableTrait;
    protected $guarded = [];
}
