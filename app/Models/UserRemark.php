<?php

namespace App\Models;

use App\Http\Traits\ActiveTrait;
use App\Http\Traits\FindByTrait;
use App\Http\Traits\SortableTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class UserRemark extends Model
{
    use ActiveTrait,FindByTrait,SortableTrait;
    protected $guarded = [];



    public static function boot()
    {
        parent::boot();
        static::creating(function($model)
        {
            $user=Auth::guard('api')->user();

            unset($model->remarker_id);
            $model->remarker_id=$user->id;
        });
        static::updating(function($model){
           $model->remarker_id=$model->getOriginal('remarker_id');
        });
    }
    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function remarker()
    {
        return $this->belongsTo(User::class,'remarker_id');
    }
}
