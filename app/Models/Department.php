<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Department extends Model
{
    public function head()
    {
        return $this->belongsTo(User::class,'head_id');
    }
}
