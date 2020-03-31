<?php

namespace App\Models;

use App\Http\Traits\ActiveTrait;
use App\Http\Traits\FindByTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BillingSystem extends Model
{
    use ActiveTrait,FindByTrait,SoftDeletes;
    protected $guarded = [];
}
