<?php

namespace App\Models;

use App\Http\Traits\FindByTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SurgicalHistory extends Model
{
    use FindByTrait,SoftDeletes;
}
