<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EpisodeServiceAndProduct extends Model
{
    public function serviceable()
    {
        return $this->morphTo();
    }
}
