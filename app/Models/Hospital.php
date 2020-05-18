<?php

namespace App\Models;

use App\Http\Helpers\FileResolver;
use App\Http\Traits\Eloquent\FindByTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Hospital extends Model
{
    use FindByTrait;
    protected $guarded = [];
    public static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->logo = FileResolver::base64ToFile($model->logo, 'logo', 'logos') ?? null;
        });

        static::updating(function ($model) {
            $model->logo = FileResolver::base64ToFile($model->logo, 'logo', 'logos') ?? null;
        });
    }
    public function accreditations()
    {
        return $this->belongsTo(Accreditation::class);
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function region()
    {
        return $this->belongsTo(Region::class);
    }
}
