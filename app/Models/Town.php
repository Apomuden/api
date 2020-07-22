<?php

namespace App\Models;

use App\Http\Traits\Eloquent\ActiveTrait;
use App\Http\Traits\Eloquent\FindByTrait;
use App\Http\Traits\Eloquent\SortableTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Town extends AuditableModel
{
    use ActiveTrait;
    use SortableTrait;
    use FindByTrait;
    use SoftDeletes;

    protected $guarded = [];

    public function district()
    {
        return $this->belongsTo(District::class);
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function region()
    {
        return $this->belongsTo(Region::class);
    }

    public function patients()
    {
        return $this->hasMany(Patient::class);
    }
}
