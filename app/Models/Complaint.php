<?php

namespace App\Models;

use App\Http\Traits\Eloquent\FindByTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Complaint extends Model
{
    use FindByTrait, SoftDeletes;
    protected $guarded = [];

    public function complaint_type()
    {
        return $this->belongsTo(ComplaintType::class);
    }
}
