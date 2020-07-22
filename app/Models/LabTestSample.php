<?php

namespace App\Models;

use App\Http\Traits\Eloquent\FindByTrait;
use App\Models\LabParameterRange;
use App\Models\Service;
use App\Repositories\RepositoryEloquent;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class LabTestSample extends AuditableModel
{
    use FindByTrait;
    use SoftDeletes;

    protected $guarded = [];

    public static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $user = Auth::guard('api')->user();
            if (!$model->technician_id) {
                $model->technician_id = $user->id;
            }

            $model->user_id = $user->id;

            $investigation = $model->investigation;
            $model->service_id = $investigation->service_id;
            $model->patient_id = $investigation->patient_id;

            Log::critical('investigation', $model->toArray());

            $model->lab_sample_type_order = $investigation->service->lab_sample_types()->where('lab_sample_type_id', $model->lab_sample_type_id)->firstOrFail()->pivot->order;
        });
        static::created(function ($model) {
            $model->investigation->status = 'SAMPLE-TAKEN';
            $model->investigation->save();
        });

        static::updating(function ($model) {
            if ($model->investigation_id) {
                $investigation = Investigation::findOrFail($model->investigation_id);
                $model->service_id = $investigation->service_id;
                $model->patient_id = $investigation->patient_id;
                $model->lab_sample_type_order = $investigation->service->lab_sample_types()->where('lab_sample_type_id', $model->lab_sample_type_id)->firstOrFail()->pivot->order;
            }

            $user = Auth::guard('api')->user();
            if (!$model->technician_id) {
                $model->technician_id = $user->id;
            }

            $model->user_id = $user->id;
        });
    }
    public function lab_sample_type()
    {
        return $this->belongsTo(LabSampleType::class);
    }

    public function investigation()
    {
        return $this->belongsTo(Investigation::class);
    }

    public function technician()
    {
        return $this->belongsTo(User::class, 'technician_id');
    }

    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approver_id');
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}
