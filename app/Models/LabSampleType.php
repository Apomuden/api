<?php

namespace App\Models;

use App\Http\Traits\Eloquent\FindByTrait;
use App\Models\LabParameterRange;
use App\Models\Service;
use App\Repositories\RepositoryEloquent;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class LabSampleType extends AuditableModel
{
    use FindByTrait;
    use SoftDeletes;

    protected $guarded = [];
}
