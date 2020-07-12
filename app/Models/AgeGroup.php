<?php

namespace App\Models;

use App\Http\Traits\Eloquent\ActiveTrait;
use App\Http\Traits\Eloquent\FindByTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AgeGroup extends AuditableModel
{
    use ActiveTrait, FindByTrait, SoftDeletes;
    protected $guarded = [];

    public function clinic()
    {
        return $this->hasMany(Clinic::class);
    }

    public function consultation()
    {
        return $this->hasMany(Consultation::class);
    }

    // public function age_group_()
    // {
    //     return $this->belongsTo(AgeGroup::class);
    // }

    public function getAgeNameAttribute(){
        $min_age_days=0;$max_age_days=0;
        switch($this->max_age_unit){
            case 'YEAR':
                $max_age_days=$this->max_age*365;
            break;
            case 'MONTH':
                $max_age_days=$this->max_age*30;
            break;
            case 'WEEK':
                $max_age_days=$this->max_age*7;
            break;
            default:
                $max_age_days= $this->max_age;
            break;
        }
        switch($this->min_age_unit){
            case 'YEAR':
                $min_age_days=$this->min_age*365;
            break;
            case 'MONTH':
                $min_age_days=$this->min_age*30;
            break;
            case 'WEEK':
                $min_age_days=$this->min_age*7;
            break;
            default:
                $min_age_days= $this->min_age;
            break;
        }

       $twelve_years=12*365;
       if($min_age_days<$twelve_years && $twelve_years<$max_age_days)
       $age_name='ALL';
       else if($min_age_days>$twelve_years)
       $age_name='ADULT';
       else if($min_age_days < $twelve_years)
       $age_name='CHILD';

       return $age_name;
    }
}
