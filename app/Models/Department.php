<?php

namespace App\Models;

use App\Http\Traits\ActiveTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Department extends Model
{
    use ActiveTrait;

    protected $guarded = [];
    public function head()
    {
        return $this->belongsTo(User::class,'head_id');
    }

    public function deputy_head()
    {
        return $this->belongsTo(User::class,'deputy_head_id');
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
