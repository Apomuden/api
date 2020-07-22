<?php

namespace App\Models;

use App\Http\Traits\Eloquent\ActiveTrait;
use App\Http\Traits\Eloquent\FindByTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Department extends AuditableModel
{
    use ActiveTrait;
    use FindByTrait;
    use SoftDeletes;

    protected $guarded = [];
    public function head()
    {
        return $this->belongsTo(User::class, 'head_id');
    }

    public function deputy_head()
    {
        return $this->belongsTo(User::class, 'deputy_head_id');
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
