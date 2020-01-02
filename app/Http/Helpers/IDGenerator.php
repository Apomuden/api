<?php
namespace App\Http\Helpers;

use App\Models\Folder;
use App\Models\Hospital;
use App\Models\Patient;
use App\Models\User;
use App\Repositories\HospitalEloquent;

class IDGenerator{
    static function getNewStaffID(){

            //Creating the Staff ID
            $repository=new HospitalEloquent(new Hospital);
            $hospital=$repository->first();
            //get last max ID
            //$lastID=User::whereYear('created_at',date('Y'))->max('staff_id');
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
        $lastID=Patient::whereYear('created_at',date('Y'))->whereMonth('created_at',date('m'))->max('patient_id');
        $id_parts=explode('/',$lastID);

        $month=date('m');
        $year=date('y');

        $number=intval($id_parts[0])+1;

        return sprintf('%07d',$number).$year.''.$month;
    }

    static function getNewFolderNo(){
           //Creating the Folder ID
           $repository=new HospitalEloquent(new Hospital);
           $hospital=$repository->first();
           //get last max ID
           $lastID=Folder::whereYear('created_at',date('Y'))->whereMonth('created_at',date('m'))->max('folder_no');
           $id_parts=$hospital->folder_id_seperator?explode($hospital->folder_id_seperator,$lastID):$lastID;

           $year=date('y');
           $month=date('m');


           switch($hospital->year_digits){
               case 4;
                  $year=date('Y');
               break;
               case 3;
                 $year='0'.date('y');
               break;
           }

           $yearMonth=sprintf('%0'.(strlen($year)+2).'d',$month.$year);

           if(is_array($id_parts))
           $number=trim(str_replace($hospital->folder_id_seperator,'',$id_parts[0]));
           else
           $number=$id_parts;

           $number=str_replace($yearMonth,'', str_replace($hospital->folder_id_prefix,'',$number));

           $number=is_numeric($number)?(intval($number)+1):1;

           return $hospital->folder_id_prefix.sprintf('%0'.$hospital->digits_after_folder_prefix.'d',$number).$hospital->folder_id_seperator.$yearMonth;
    }
}
