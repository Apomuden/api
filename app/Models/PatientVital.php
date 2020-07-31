<?php

namespace App\Models;

use App\Http\Traits\Eloquent\ActiveTrait;
use App\Http\Traits\Eloquent\FindByTrait;
use App\Http\Traits\Eloquent\SortableTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PatientVital extends AuditableModel
{
    use ActiveTrait;
    use FindByTrait;
    use SortableTrait;
    use SoftDeletes;

    protected $guarded = [];

    public static function calculateAndReturnBMI($model)
    {
        if ($model->height) {
            $height = ($model->height ?? $model->getOriginal('height')) ?? 0;
            $weight = ($model->weight ?? $model->getOriginal('weight')) ?? null;
            $heightInMeters = ($height * 0.01); //Converting from cm to m
            return ($heightInMeters && $weight) ? ((float) ($weight / ($heightInMeters ** 2))) : null;
        }
        return 0;
    }
    public static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->bmi = self::calculateAndReturnBMI($model);

            if(!$model->attendance_date)
            $model->attendance_date=now()->format('Y-m-d H:i:s');
            else
            $model->attendance_date=Carbon::parse($model->attendance_date)->format('Y-m-d H:i:s');
        });

        static::updating(function ($model) {
            $model->bmi = self::calculateAndReturnBMI($model);

            if($model->isDirty('attendance_date')){
                if (!$model->attendance_date)
                    $model->attendance_date = now()->format('Y-m-d H:i:s');
                else
                    $model->attendance_date = Carbon::parse($model->attendance_date)->format('Y-m-d H:i:s');
            }

        });
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}
