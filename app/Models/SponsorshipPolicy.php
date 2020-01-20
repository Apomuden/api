<?php

namespace App\Models;

use App\Http\Traits\ActiveTrait;
use App\Http\Traits\FindByTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SponsorshipPolicy extends Model
{
    use ActiveTrait,FindByTrait,SoftDeletes;
    protected $guarded = [];

     public function billing_sponsor()
     {
         return $this->belongsTo(BillingSponsor::class);
     }
}
