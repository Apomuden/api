<?php

namespace App\Models;

use App\Http\Traits\ActiveTrait;
use Illuminate\Database\Eloquent\Model;

class StaffNextOfKin extends Model
{
    use ActiveTrait;
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function relationship()
    {
        return $this->belongsTo(Relationship::class,'relation_id');
    }

}
