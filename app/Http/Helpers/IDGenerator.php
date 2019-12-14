<?php
namespace App\Http\Helpers;

use App\Models\Hospital;
use App\Models\Patient;
use App\Models\User;

class IDGenerator{
    static function getNewStaffID(){

            //Creating the Staff ID
            $hospital=Hospital::firstOrFail();
            //get last max ID
            $lastID=User::max('staff_id');
            $id_parts=$lastID?explode($hospital->staff_id_seperator,$lastID):null;

            $year=date('y');

            switch($hospital->year_digits){
                case 4;
                   $year=date('Y');
                break;
                case 3;
                  $year='0'.date('y');
                break;

            }
            if(!is_array($id_parts))
                $number=1;
            else{
               $number=intval(trim(str_replace($hospital->staff_id_prefix,'',$id_parts[0])))+1;
            }
            return $hospital->staff_id_prefix.sprintf('%0'.$hospital->digits_after_staff_prefix.'d',$number).$hospital->staff_id_seperator.$year;
    }

    static function getNewPatientID(){
        $lastID=Patient::max('patient_id');
        $id_parts=explode('/',$lastID);
        $year=date('y');

        $number=intval($id_parts[0])+1;

        return sprintf('%06d',$number);
    }
}
