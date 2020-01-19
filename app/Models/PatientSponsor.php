<?php

namespace App\Models;

use App\Http\Traits\ActiveTrait;
use App\Http\Traits\FindByTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PatientSponsor extends Model
{
    use ActiveTrait,FindByTrait,SoftDeletes;
    public function sponsor()
    {
        return $this->belongsTo(BillingSponsor::class);
    }

    public function sponsorship_type()
    {
        return $this->belongsTo(SponsorshipType::class);
    }

    public function patients()
    {
        return $this->hasMany(Patient::class);
    }

    public function relationship()
    {
        return $this->belongsTo(Relationship::class,'relation_id');
    }
}
