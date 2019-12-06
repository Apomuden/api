<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hospital extends Model
{
    protected $guarded = [];

    public function accreditations()
    {
        return $this->belongsTo(Accreditation::class);
    }
}
