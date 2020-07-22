<?php

namespace App\Models;

use App\Http\Traits\Eloquent\ActiveTrait;
use App\Http\Traits\Eloquent\FindByTrait;
use App\Http\Traits\Eloquent\SortableTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PatientVital extends AuditableModel
{
    use ActiveTrait, FindByTrait, SortableTrait, SoftDeletes;
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
        });

        static::updating(function ($model) {
            $model->bmi = self::calculateAndReturnBMI($model);
        });
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}
