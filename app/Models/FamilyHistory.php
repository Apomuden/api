<?php

namespace App\Models;

use App\Http\Traits\FindByTrait;
use App\Http\Traits\SortableTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FamilyHistory extends Model
{
    use FindByTrait,SortableTrait,SoftDeletes;

    public function family_history_category()
    {
        return $this->belongsTo(FamilyHistoryCategory::class);
    }
}
