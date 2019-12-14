<?php

namespace App\Models;

use App\Http\Traits\ActiveTrait;
use Illuminate\Database\Eloquent\Model;

class PatientSponsors extends Model
{
    use ActiveTrait;
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
}
