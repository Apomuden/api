<?php

namespace App\Models;

use App\Http\Traits\FindByTrait;
use Illuminate\Database\Eloquent\Model;

class Folder extends Model
{
    use FindByTrait;
    protected $guarded = [];
    public function patients()
    {
        return $this->belongsToMany(Patient::class);
    }
}
