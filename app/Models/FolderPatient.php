<?php

namespace App\Models;

use App\Http\Traits\Eloquent\FindByTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FolderPatient extends AuditableModel
{
    use FindByTrait;

    protected $guarded = [];
}
