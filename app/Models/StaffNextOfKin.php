<?php

namespace App\Models;

use App\Http\Traits\ActiveTrait;
use App\Http\Traits\FindByTrait;
use Illuminate\Database\Eloquent\Model;

class StaffNextOfKin extends Model
{
    use ActiveTrait,FindByTrait;
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
