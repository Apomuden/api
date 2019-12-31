<?php

namespace App\Models;

use App\Http\Traits\FindByTrait;
use Illuminate\Database\Eloquent\Model;

class Relationship extends Model
{
    use FindByTrait;
    protected $guarded = [];
}
