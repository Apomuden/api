<?php

namespace App\Models;

use App\Http\Traits\Eloquent\FindByTrait;
use App\Models\LabParameter;
use App\Models\Service;
use App\Repositories\RepositoryEloquent;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class LabParameterRange extends Model
{
    use FindByTrait, SoftDeletes;
    protected $guarded = [];

    public function lab_parameter()
    {
        return $this->belongsTo(LabParameter::class);
    }

    public function age_group()
    {
        return $this->belongsTo(AgeGroup::class);
    }
}
