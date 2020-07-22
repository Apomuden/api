<?php

namespace App\Models;

use App\Http\Traits\Eloquent\FindByTrait;
use App\Http\Traits\Eloquent\SortableTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MedicineHistory extends AuditableModel
{
    use FindByTrait;
    use SortableTrait;
    use SoftDeletes;

    protected $guarded = [];

    public function medicine_history_category()
    {
        return $this->belongsTo(MedicineHistoryCategory::class);
    }
}
