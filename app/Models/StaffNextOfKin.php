<?php

namespace App\Models;

use App\Http\Traits\ActiveTrait;
use Illuminate\Database\Eloquent\Model;

class StaffNextOfKin extends Model
{
    use ActiveTrait;
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
