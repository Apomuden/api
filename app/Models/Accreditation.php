<?php

namespace App\Models;

use App\Http\Helpers\DateHelper;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Accreditation extends Model
{
    protected $guarded = [];


    public static function boot()
    {
        parent::boot();
        static::creating(function($model)
        {

            //format dates
            $model->reg_date =DateHelper::toDBDate($model->reg_date);
            $model->expiry_date =DateHelper::toDBDate($model->expiry_date);

        });
    }

}
