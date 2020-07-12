<?php

namespace App\Models;

use App\Http\Traits\Eloquent\FindByTrait;
use App\Http\Traits\Eloquent\SortableTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FamilyHistory extends AuditableModel
{
    use FindByTrait, SortableTrait, SoftDeletes;
    protected $guarded = [];

    public function family_history_category()
    {
        return $this->belongsTo(FamilyHistoryCategory::class);
    }
}
