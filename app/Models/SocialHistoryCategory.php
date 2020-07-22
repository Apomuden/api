<?php

namespace App\Models;

use App\Http\Traits\Eloquent\FindByTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SocialHistoryCategory extends AuditableModel
{
    use FindByTrait;
    use SoftDeletes;

    protected $guarded = [];
}
