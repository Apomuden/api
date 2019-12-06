<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Folder extends Model
{
    protected $guarded = [];
    public function patients()
    {
        return $this->belongsToMany(Patient::class);
    }
}
