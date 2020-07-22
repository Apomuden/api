<?php

namespace App\Models\Obstetrics;

use App\Models\District;
use App\Models\EducationalLevel;
use App\Models\Patient;
use App\Models\Region;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use App\Http\Traits\Eloquent\ActiveTrait;
use App\Http\Traits\Eloquent\FindByTrait;
use App\Http\Traits\Eloquent\SortableTrait;
use App\Models\AuditableModel;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class ObsFamilyInformation extends AuditableModel
{
    use ActiveTrait;
    use FindByTrait;
    use SortableTrait;
    use SoftDeletes;

    protected $guarded = [];

    public static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $patient = Patient::findOrFail($model->patient_id);
            $model->patient_age = $patient->age;
            $model->user_id = Auth::guard('api')->user()->id;
        });
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function partner_region()
    {
        return $this->belongsTo(Region::class, 'partner_region_id');
    }

    public function partner_district()
    {
        return $this->belongsTo(District::class, 'partner_district_id');
    }

    public function partner_educational_level()
    {
        return $this->belongsTo(EducationalLevel::class, 'partner_educational_level_id');
    }
}
