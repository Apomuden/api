<?php

namespace App;

use App\Http\Traits\FindByTrait;
use App\Models\LabParameterRange;
use App\Models\Service;
use App\Repositories\RepositoryEloquent;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class LabParameter extends Model
{
    use FindByTrait, SoftDeletes;
    protected $guarded = [];

    public function lab_services()
    {
        return $this->belongsToMany(Service::class, 'lab_service_parameters');
    }

    public function lab_paramter_ranges()
    {
        return $this->hasMany(LabParameterRange::class);
    }
}
