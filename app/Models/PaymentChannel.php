<?php

namespace App\Models;

use App\Http\Traits\Eloquent\ActiveTrait;
use App\Http\Traits\Eloquent\FindByTrait;
use App\Http\Traits\Eloquent\SortableTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PaymentChannel extends AuditableModel
{
    use ActiveTrait;
    use FindByTrait;
    use SortableTrait;
    use SoftDeletes;

    protected $guarded = [];

    public function funding_type()
    {
        return $this->hasMany(FundingType::class);
    }

    public function patients()
    {
        return $this->hasMany(Patient::class);
    }

    public static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if ($model->priority == 0)
                self::where('priority',0)->update(['priority' => 1]);
        });
        static::updating(function ($model) {
            if ($model->isDirty('priority') && $model->priority == 0)
                self::where('priority', 0)->update(['priority' => 1]);
        });
    }
}
