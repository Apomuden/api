<?php

namespace App\Models;

use App\Http\Traits\ActiveTrait;
use App\Http\Traits\FindByTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PhysicalExaminationType extends Model
{
    use ActiveTrait, FindByTrait, SoftDeletes;
    protected $guarded = [];

    public function physical_examination_category()
    {
        return $this->belongsTo(PhysicalExaminationCategory::class, 'category_id');
    }
}
