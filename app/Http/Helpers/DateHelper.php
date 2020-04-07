<?php
namespace App\Http\Helpers;

use App\Http\Utils\DateFormater;
use App\Models\AgeCategory;
use App\Models\Attendance;
use App\Repositories\RepositoryEloquent;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DateHelper
{
   static function toDisplayDate($date){
      return $date? (new DateFormater($date))->toDisplayDate():null;
   }
    static function toDBDate($date){
        return $date? (new DateFormater($date))->toDBDate():null;
    }

    static function toDisplayDateTime($date){
        return $date? (new DateFormater($date))->toDisplayDateTime():null;
    }
    static function toDBDateTime($date){
       return $date? (new DateFormater($date))->toDBDateTime():null;
    }
    static function hasAttendedToday($patient_id, $clinic_id,$service_id){
        $repository = new RepositoryEloquent(new Attendance);
        return boolval($repository->findWhere(['patient_id' => $patient_id])
            ->where('clinic_id', $clinic_id)
            ->where('service_id',$service_id)
            ->whereDate('created_at', Carbon::today())
            ->count());
    }
    static function isNewAttendance($patient_id,$clinic_id){
        $repository = new RepositoryEloquent(new Attendance);
        return !$repository->findWhere(['patient_id' =>$patient_id])->where('clinic_id',$clinic_id)
            ->whereYear('created_at',Carbon::today())
            ->count();
    }
    static function getDOB($years)
    {
        return date('Y-m-d', strtotime($years . ' years ago'));
    }
    static function getAgeCategory($age_class_id,$dob){

        if(Carbon::now()->diffInDays(Carbon::parse($dob)) <= 28){
            $age= Carbon::now()->diffInDays(Carbon::parse($dob));
            $unit='DAY';
        }
        else if (Carbon::now()->diffInMonths(Carbon::parse($dob)) >= 12) {
            $age = Carbon::parse($dob)->age;
            $unit = 'YEAR';
        }
        else{
            $age= Carbon::now()->diffInMonths(Carbon::parse($dob));
            $unit='MONTH';
        }


        $repository = new RepositoryEloquent(new AgeCategory);
        $age_categories = $repository
        ->findWhere(['age_classification_id' => $age_class_id])

        ->orderBy('min_age')
            ->get();


        foreach($age_categories as $age_category){
            if($age_category->min_comparator=='>=' && $age_category->min_unit==$unit && $age>=$age_category->min_age){
                if ($age_category->max_comparator == '<=' && $age_category->max_unit == $unit && $age <= $age_category->max_age)
                    return $age_category;
                else if ($age_category->max_comparator == '<' && $age_category->max_unit == $unit && $age < $age_category->max_age)
                    return $age_category;
                   continue;
            }
            else if($age_category->min_comparator == '>' && $age_category->min_unit == $unit && $age > $age_category->min_age){
                if ($age_category->max_comparator == '<=' && $age_category->max_unit == $unit && $age <= $age_category->max_age)
                    return $age_category;
                else if ($age_category->max_comparator == '<' && $age_category->max_unit == $unit && $age < $age_category->max_age)
                    return $age_category;
                continue;
            }
            else if($age_category->min_comparator == '=' && $age_category->min_unit == $unit && $age = $age_category->min_age){
                if ($age_category->max_comparator == '<=' && $age_category->max_unit == $unit && $age <= $age_category->max_age)
                    return $age_category;
                else if ($age_category->max_comparator == '<' && $age_category->max_unit == $unit && $age < $age_category->max_age)
                    return $age_category;
                continue;
            }

        }
    }
}
