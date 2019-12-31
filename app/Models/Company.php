<?php

namespace App\Models;

use App\Http\Traits\ActiveTrait;
use App\Http\Traits\FindByTrait;
use App\Http\Traits\SortableTrait;
use App\Repositories\HospitalEloquent;
use App\Repositories\RepositoryEloquent;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
   use ActiveTrait,SortableTrait,FindByTrait;
   protected $guarded = [];

  /*  public static function boot()
    {
        parent::boot();
        static::creating(function($model)
        {
            $repository=new HospitalEloquent(new Hospital);
            $hospital=$repository->first();
            if(strlen($model->phone)<=10)
            $model->phone=$hospital->country->call_code.str_replace($hospital->country->call_code,'',intval($model->phone));
        });
    } */
}
