<?php

namespace App\Models;

use App\Http\Traits\Eloquent\ActiveTrait;
use App\Http\Traits\Eloquent\FindByTrait;
use App\Http\Traits\Eloquent\SortableTrait;
use App\Repositories\HospitalEloquent;
use App\Repositories\RepositoryEloquent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends AuditableModel
{
    use ActiveTrait;
    use SortableTrait;
    use FindByTrait;
    use SoftDeletes;

    protected $guarded = [];

    public function billing_sponsors()
    {
        return $this->hasMany(BillingSponsor::class);
    }
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
