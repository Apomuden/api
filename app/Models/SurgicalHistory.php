<?php

namespace App\Models;

use App\Http\Traits\Eloquent\FindByTrait;
use App\Http\Traits\Eloquent\SortableTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SurgicalHistory extends Model
{
    use FindByTrait, SortableTrait, SoftDeletes;
    protected $guarded = [];

    public function surgical_history_category()
    {
        return $this->belongsTo(SurgicalHistoryCategory::class);
    }
}
