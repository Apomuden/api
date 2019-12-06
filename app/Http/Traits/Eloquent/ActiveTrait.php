<?php
namespace App\Http\Traits;
trait ActiveTrait
{
    function active($query,$status='ACTIVE'){
       return $query->where('status',$status);
    }
}
