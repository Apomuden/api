<?php

namespace App\Models;

use App\Http\Helpers\FileResolver;
use App\Http\Helpers\IDGenerator;
use App\Http\Traits\ActiveTrait;
use App\Http\Traits\FindByTrait;
use App\Http\Traits\SortableTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Folder extends Model
{
    use ActiveTrait,FindByTrait,SortableTrait,SoftDeletes;
    protected $guarded = [];
    public function patients()
    {
        return $this->belongsToMany(Patient::class);
    }

    public static function boot()
    {
        parent::boot();
        static::creating(function($model)
        {
            $model->folder_no=IDGenerator::getNewFolderNo();
        });
   }
}
