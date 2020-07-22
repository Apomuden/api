<?php

namespace App\Models;

use App\Http\Traits\Eloquent\ActiveTrait;
use App\Http\Traits\Eloquent\FindByTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class District extends AuditableModel
{
    use ActiveTrait;
    use FindByTrait;
    use SoftDeletes;

    protected $guarded = [];

    public function region()
    {
        return $this->belongsTo(Region::class);
    }

    public function patients()
    {
        return $this->hasMany(Patient::class);
    }

    public function towns()
    {
        return $this->hasMany(Town::class);
    }
}
