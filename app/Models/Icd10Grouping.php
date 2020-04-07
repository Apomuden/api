<?php

namespace App\Models;

use App\Http\Traits\ActiveTrait;
use App\Http\Traits\FindByTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Icd10Grouping extends Model
{
    use ActiveTrait, FindByTrait, SoftDeletes;
    protected $guarded = [];

    public function icd10category()
    {
        return $this->belongsTo(Icd10Category::class, 'icd10_category_id');
    }
}
