<?php

namespace App\Models;

use App\Http\Traits\ActiveTrait;
use App\Http\Traits\FindByTrait;
use App\Http\Traits\SortableTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PatientVital extends Model
{
    use ActiveTrait,FindByTrait,SortableTrait,SoftDeletes;
    protected $guarded = [];

    public static function calculateAndReturnBMI($model)
    {
        if($model->height) {
            $height = ($model->height??$model->getOriginal('height'))??null;
            $weight = ($model->height??$model->getOriginal('height'))??null;
            $heightInMeters = ($height * 0.01); //Converting from cm to m
            return (float)($weight / ($heightInMeters ** 2));
        }
    }
    public static function boot()
    {
        parent::boot();
        static::creating(function($model){
            $model->bmi = self::calculateAndReturnBMI($model);
        });

        static::updating(function($model){
            $model->bmi = self::calculateAndReturnBMI($model);
        });
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}
