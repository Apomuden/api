<?php

namespace App\Models;

use App\Http\Traits\FindByTrait;
use Illuminate\Database\Eloquent\Model;

class PermissionUser extends Model
{
    use FindByTrait;
    protected $guarded = [];

}
