<?php

namespace App\Models;

use App\Http\Traits\ActiveTrait;
use App\Http\Traits\FindByTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AllergyHistory extends Model
{
    use ActiveTrait, FindByTrait, SoftDeletes;

    public function allergy_history_category()
    {
        return $this->belongsTo(AllergyHistoryCategory::class);
    }

}
