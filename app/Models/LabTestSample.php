<?php

namespace App\Models;

use App\Http\Traits\FindByTrait;
use App\Models\LabParameterRange;
use App\Models\Service;
use App\Repositories\RepositoryEloquent;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class LabTestSample extends Model
{
    use FindByTrait, SoftDeletes;
    protected $guarded = [];

    public function lab_sample_type()
    {
        return $this->belongsTo(LabSampleType::class);
    }

    
}
