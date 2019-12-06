<?php
namespace App\Http\Helpers;

use App\Models\Hospital;
use App\Models\User;

class IDGenerator{
    static function getNewStaffID(){

            //Creating the Staff ID
            $hospital=Hospital::firstOrFail();
            //get last max ID
            $lastID=User::max('staff_id');
            $id_parts=$lastID?explode($hospital->staff_id_seperator,$lastID):null;

            $year=date('y');
            if(!is_array($id_parts))
                $number=1;
            else{
               $number=intval($id_parts[count($id_parts)-2])+1;
            }
            return$hospital->staff_id_prefix.$hospital->staff_id_seperator.sprintf('%03d',$number).$hospital->staff_id_seperator.$year;
    }
}
