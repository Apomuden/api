<?php

namespace App\Models;

use App\Http\Traits\ActiveTrait;
use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    use ActiveTrait;
    protected $guarded = [];

    public function branches()
    {
        return $this->hasMany(BankBranch::class);
    }
}
