<?php

namespace App\Models;

use App\Http\Traits\Eloquent\ActiveTrait;
use App\Http\Traits\Eloquent\FindByTrait;
use App\Http\Traits\Eloquent\SortableTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class UserRemark extends AuditableModel
{
    use ActiveTrait;
    use FindByTrait;
    use SortableTrait;
    use SoftDeletes;

    protected $guarded = [];
    public static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $user = Auth::guard('api')->user();

            unset($model->remarker_id);
            $model->remarker_id = $user->id;
        });
        static::updating(function ($model) {
            $model->remarker_id = $model->getOriginal('remarker_id');
        });
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function remarker()
    {
        return $this->belongsTo(User::class, 'remarker_id');
    }
}
