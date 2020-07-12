<?php

namespace App\Models;

use App\Http\Traits\Eloquent\ActiveTrait;
use App\Http\Traits\Eloquent\FindByTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ConsultationComponent extends AuditableModel
{
    use SoftDeletes, ActiveTrait, FindByTrait;

    public function clinic_services()
    {
        return $this->belongsToMany(ClinicService::class, 'services_consultation_components');
    }
}
