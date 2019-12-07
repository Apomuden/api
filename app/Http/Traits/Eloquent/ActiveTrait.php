<?php
namespace App\Http\Traits;
trait ActiveTrait
{
    function scopeActive($query,$status='ACTIVE'){
       return $query->where('status',$status);
    }
}
