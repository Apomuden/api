<?php

namespace App\Models;

use App\Http\Traits\Eloquent\ActiveTrait;
use App\Http\Traits\Eloquent\FindByTrait;
use App\Http\Traits\Eloquent\SortableTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Store extends AuditableModel
{
    use ActiveTrait;
    use FindByTrait;
    use SoftDeletes;
    use SortableTrait;

    protected $guarded = [];

    public function store_activity()
    {
        return $this->hasOne(StoreActivity::class);
    }
}
