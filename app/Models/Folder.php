<?php

namespace App\Models;

use App\Http\Helpers\FileResolver;
use App\Http\Helpers\IDGenerator;
use App\Http\Traits\Eloquent\ActiveTrait;
use App\Http\Traits\Eloquent\FindByTrait;
use App\Http\Traits\Eloquent\SortableTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Folder extends AuditableModel
{
    use ActiveTrait;
    use FindByTrait;
    use SortableTrait;
    use SoftDeletes;

    protected $guarded = [];
    public function patients()
    {
        return $this->belongsToMany(Patient::class, 'folder_patients');
    }

    public static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->folder_no = IDGenerator::getNewFolderNo();
        });
    }
}
