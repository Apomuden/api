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

    public static function calculateAndSaveBMI($model)
    {
        if($model->height) {
            $heightInMeters = ($model->height * 0.01); //Converting from cm to m
            $model->bmi = (float)($model->weight / ($heightInMeters ** 2));
            $model->save();
            unset($model);
        }
    }
    public static function boot()
    {
        parent::boot();
        static::created(function($model){
            self::calculateAndSaveBMI($model);
            unset($model);
        });

        static::updated(function($model){
            self::calculateAndSaveBMI($model);
            unset($model);
        });
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}
