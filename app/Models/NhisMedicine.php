<?php

namespace App\Models;

use App\Http\Traits\Eloquent\ActiveTrait;
use App\Http\Traits\Eloquent\FindByTrait;
use App\Http\Traits\Eloquent\SortableTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NhisMedicine extends AuditableModel
{
    use ActiveTrait;
    use SortableTrait;
    use FindByTrait;
    use SoftDeletes;

    protected $guarded = [];
    public static function boot()
    {
        parent::boot();
        static::created(function ($model) {
            //updating existing products with nhis_medicine_id
                Products::whereNhisCode($model->code)
                    ->update(['nhis_medicine_id' => $model->id]);
        });
        static::updated(function ($model) {
            //updating existing products with nhis_medicine_id
            if($model->isDirty('code'))
            Products::whereNhisMedicineId($model->id)
                ->update(['nhis_code' => $model->code]);
        });
    }

    public function products()
    {
        return $this->hasMany(Products::class);
    }
}
