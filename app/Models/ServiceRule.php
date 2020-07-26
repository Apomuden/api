<?php

namespace App\Models;

use App\Http\Traits\Eloquent\ActiveTrait;
use App\Http\Traits\Eloquent\FindByTrait;
use App\Http\Traits\Eloquent\SortableTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

class ServiceRule extends AuditableModel
{
    use ActiveTrait,FindByTrait,SortableTrait,SoftDeletes;

    public static function boot()
    {
        parent::boot();
        static::creating(function ($model) {

            if(!$model->patient_status)
            unset($model->patient_status);

            if(!$model->status)
            unset($model->patient_status);
        });

        static::updating(function ($model) {
            if($model->isDirty('patient_status') && !$model->patient_status)
                unset($model->patient_status);

            if($model->isDirty('status') && !$model->status)
                unset($model->patient_status);


        });
    }
}
