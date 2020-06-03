<?php

namespace App\Models;

use App\Http\Helpers\FileResolver;
use Illuminate\Database\Eloquent\Model;

class NhisAccreditationSetting extends Model
{
    protected $guarded = [];
    public static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->claim_manager_signature = FileResolver::base64ToFile($model->claim_manager_signature, 'claim-manager-sign', 'users' . DIRECTORY_SEPARATOR . 'signatures') ?? null;
        });

        static::updating(function ($model) {
            $model->claim_manager_signature = FileResolver::base64ToFile($model->claim_manager_signature, 'claim-manager-sign', 'users' . DIRECTORY_SEPARATOR . 'signatures') ?? null;
        });
    }

    public function nhis_provider_level()
    {
        return $this->belongsTo(NhisProviderLevel::class);
    }
}
