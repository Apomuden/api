<?php

namespace App\Models;

use App\Http\Traits\ActiveTrait;
use App\Http\Traits\FindByTrait;
use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    use ActiveTrait,FindByTrait;
    protected $guarded = [];

    public function branches()
    {
        return $this->hasMany(BankBranch::class);
    }
}
