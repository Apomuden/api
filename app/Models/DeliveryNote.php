<?php

namespace App\Models;

use App\Http\Traits\ActiveTrait;
use App\Http\Traits\FindByTrait;
use App\Http\Traits\SortableTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class DeliveryNote extends Model
{
    use ActiveTrait, FindByTrait, SortableTrait, SoftDeletes;
    protected $guarded = [];
    public static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $user = Auth::guard('api')->user();

            $model->user_id = $user->id;
            if ($model->status == 'CANCELLED') {
                $model->cancelled_date = now();
                $user = Auth::guard('api')->user();
                $model->canceller_id = $user->id;
            }
        });
        static::updating(function ($model) {
            $user = Auth::guard('api')->user();

            $model->user_id = $user->id;
            if ($model->status == 'CANCELLED' && $model->getOriginal('status') != 'CANCELLED') {
                $model->cancelled_date = now();
                $model->canceller_id = $user->id;
            }
        });
    }
}
