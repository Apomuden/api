<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    protected $guarded = [];

    public function branches()
    {
        return $this->hasMany(BankBranch::class);
    }
}
