<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PatientVital extends Model
{
    public static function boot()
    {
        parent::boot();
        static::created(function($model){
            $heightInMeters = ($model->height * 0.01); //Converting from cm to m
            $model->bmi = (float) ($model->weight/($heightInMeters ** 2));
        });
    }
}
