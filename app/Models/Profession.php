<?php

namespace App\Models;

use App\Http\Traits\ActiveTrait;
use Illuminate\Database\Eloquent\Model;

class Profession extends Model
{
    use ActiveTrait;
    protected $guarded = [];

    public function staff_category()
    {
        return $this->belongsTo(StaffCategory::class);
    }
}
