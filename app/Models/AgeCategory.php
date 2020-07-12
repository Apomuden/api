<?php

namespace App\Models;

use App\Http\Traits\Eloquent\ActiveTrait;
use App\Http\Traits\Eloquent\FindByTrait;
use App\Http\Traits\Eloquent\SortableTrait;
use App\Repositories\RepositoryEloquent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AgeCategory extends AuditableModel
{
    use ActiveTrait, FindByTrait, SortableTrait, SoftDeletes;
    protected $guarded = [];

    public static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->description = $model->description ?? (new RepositoryEloquent(new AgeGroup()))->find($model->age_group_id)->name;
        });
    }

    public function age_group()
    {
        return $this->belongsTo(AgeGroup::class);
    }

    public function age_classification()
    {
        return $this->belongsTo(AgeClassification::class);
    }
}
