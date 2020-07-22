<?php

namespace App\Models;

use App\Http\Traits\Eloquent\FindByTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Complaint extends AuditableModel
{
    use FindByTrait;
    use SoftDeletes;

    protected $guarded = [];

    public function complaint_type()
    {
        return $this->belongsTo(ComplaintType::class);
    }
}
