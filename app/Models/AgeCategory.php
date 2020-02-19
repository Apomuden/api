<?php

namespace App\Models;

use App\Http\Traits\ActiveTrait;
use App\Http\Traits\FindByTrait;
use App\Http\Traits\SortableTrait;
use App\Repositories\RepositoryEloquent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AgeCategory extends Model
{
    use ActiveTrait,FindByTrait,SortableTrait,SoftDeletes;

    public static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->description=$model->description??(new RepositoryEloquent(new AgeGroup()))->find($model->age_group_id)->name;
        });
    }

    public function age_group() {
        return $this->belongsTo(AgeGroup::class);
    }

    public function age_classification() {
        return $this->belongsTo(AgeClassification::class);
    }
}
