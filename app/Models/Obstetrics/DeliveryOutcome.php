<?php

namespace App\Models\Obstetrics;

use App\Http\Traits\Eloquent\ActiveTrait;
use App\Http\Traits\Eloquent\FindByTrait;
use App\Models\AuditableModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DeliveryOutcome extends AuditableModel
{
    use ActiveTrait;
    use FindByTrait;
    use SoftDeletes;

    protected $guarded = [];
}
