<?php

namespace App\Models;

use App\Http\Traits\Eloquent\FindByTrait;
use App\Http\Traits\Eloquent\SortableTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MedicalHistory extends Model
{
    use FindByTrait, SortableTrait, SoftDeletes;
    protected $guarded = [];

    public function medical_history_category()
    {
        return $this->belongsTo(MedicalHistoryCategory::class);
    }
}
