<?php

namespace App\Models;

use App\Http\Traits\ActiveTrait;
use App\Http\Traits\FindByTrait;
use App\Http\Traits\SortableTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PatientSponsor extends Model
{
    use ActiveTrait,FindByTrait,SortableTrait,SoftDeletes;
    protected $guarded = [];

    public static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if($model->benefit_type=='SELF')
            $model->relation_id=null;
        });

        static::updating(function ($model) {
            if ($model->benefit_type=='SELF')
                $model->relation_id = null;
        });
    }
    public function sponsor()
    {
        return $this->belongsTo(BillingSponsor::class);
    }

    public function sponsorship_type()
    {
        return $this->belongsTo(SponsorshipType::class);
    }

    public function billing_sponsor()
    {
        return $this->belongsTo(BillingSponsor::class);
    }

    public function sponsorship_policy()
    {
        return $this->belongsTo(SponsorshipPolicy::class);
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function relationship()
    {
        return $this->belongsTo(Relationship::class,'relation_id');
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
