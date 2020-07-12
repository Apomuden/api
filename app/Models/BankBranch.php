<?php

namespace App\Models;

use App\Http\Traits\Eloquent\ActiveTrait;
use App\Http\Traits\Eloquent\FindByTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BankBranch extends AuditableModel
{
    use ActiveTrait, FindByTrait, SoftDeletes;
    protected $guarded = [];

    public function bank()
    {
        return $this->belongsTo(Bank::class);
    }
}
