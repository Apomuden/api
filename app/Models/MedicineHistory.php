<?php

namespace App\Models;

use App\Http\Traits\FindByTrait;
use App\Http\Traits\SortableTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MedicineHistory extends Model
{
    use FindByTrait,SortableTrait,SoftDeletes;
    protected $guarded = [];

    public function medical_history_category()
    {
        return $this->belongsTo(MedicalHistoryCategory::class);
    }
}
