<?php

namespace App\Models;

use App\Http\Traits\Eloquent\FindByTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SocialHistory extends Model
{
    use FindByTrait, SoftDeletes;
    protected $guarded = [];

    public function social_history_category()
    {
        return $this->belongsTo(SocialHistoryCategory::class);
    }
}
