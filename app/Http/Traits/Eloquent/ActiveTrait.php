<?php
namespace App\Http\Traits\Eloquent;
trait ActiveTrait
{
    function scopeActive($query,$status='ACTIVE'){
       return $query->where('status',$status);
    }
}
