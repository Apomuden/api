<?php

namespace App\Models;

use App\Http\Traits\Eloquent\FindByTrait;
use App\Http\Traits\Eloquent\SortableTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MedicalHistoryCategory extends AuditableModel
{
    use FindByTrait, SortableTrait, SoftDeletes;
    protected $guarded = [];
}
