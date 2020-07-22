<?php

namespace App\Models;

use App\Http\Traits\Eloquent\ActiveTrait;
use App\Http\Traits\Eloquent\FindByTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NhisGdrgServiceCoverage extends AuditableModel
{
    use ActiveTrait;
    use FindByTrait;
    use SoftDeletes;

    protected $guarded = [];

    public function nhis_gdrg_service_tariff()
    {
        return $this->belongsTo(NhisGdrgServiceTariff::class);
    }

    public static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->mdc_code = $model->nhis_gdrg_service_tariff->mdc_code;
            $model->gdrg_code = $model->nhis_gdrg_service_tariff->gdrg_code;
        });

        static::updating(function ($model) {
            if ($model->isDirty('nhis_gdrg_service_tariff_id')) {
                $model->mdc_code = $model->nhis_gdrg_service_tariff->mdc_code;
                $model->gdrg_code = $model->nhis_gdrg_service_tariff->gdrg_code;
            }
        });
    }
}
