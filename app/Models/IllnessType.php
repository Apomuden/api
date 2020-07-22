<?php

namespace App\Models;

use App\Http\Traits\Eloquent\FindByTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class IllnessType extends AuditableModel
{
    use FindByTrait, SoftDeletes;
    protected $guarded = [];
}
