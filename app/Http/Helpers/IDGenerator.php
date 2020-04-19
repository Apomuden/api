<?php
namespace App\Http\Helpers;

use App\Models\Folder;
use App\Models\Hospital;
use App\Models\LabSampleType;
use App\Models\LabTestSample;
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

    static function getNewPatientID($reg_Status=NULL){
        $repository=new HospitalEloquent(new Hospital);
        $hospital=$repository->first();
        $lastID=Patient::whereYear('created_at',date('Y'))->max('patient_id');


        if($reg_Status == 'WALK-IN')
        $lastID = str_replace($hospital->walkin_prefix, '', $lastID);

        $year=date('y');
        if($lastID)
        $number=$lastID;
        else
        $number=0;

        $number= str_replace('/' . $year, '', $number);

        if(is_numeric($number))
        $number=intval($number)+1;
        else
        $number=0;

        $number=sprintf('%07d', $number) . '/' . $year;

        return  $reg_Status == 'WALK-IN'? $hospital->walkin_prefix.$number:$number;
    }

    static function getNewFolderNo(){
           //Creating the Folder ID
           $repository=new HospitalEloquent(new Hospital);
           $hospital=$repository->first();
           //get last max ID
           $lastID=Folder::whereYear('created_at',date('Y'))->max('folder_no');
           //$id_parts=$hospital->folder_id_seperator?explode($hospital->folder_id_seperator,$lastID):$lastID;

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

           $yearMonth=sprintf('%0'.(strlen($year)).'d',$year);

           if($lastID){
             $number=trim(str_replace($hospital->folder_id_seperator.$yearMonth,'',$lastID));
             $number=str_replace($hospital->folder_id_prefix,'',$number);
           }
           else
           $number=0;

           //$number=str_replace($yearMonth,'', str_replace($hospital->folder_id_prefix,'',$number));

           $number=is_numeric($number)?intval($number)+1:1;

           return $hospital->folder_id_prefix.sprintf('%0'.$hospital->digits_after_folder_prefix.'d',$number).$hospital->folder_id_seperator.$yearMonth;
    }

    static function getNewSampleCode($investigation_id,$sample_type_id){

        $lastSample = LabTestSample::where('investigation_id', $investigation_id)->latest('created_at')->first();

        $sample_type = LabSampleType::findOrFail($sample_type_id);

        if($lastSample){
            $codePosfix = substr($lastSample->sample_code, 3, strlen($lastSample->sample_code));
            $code= $sample_type->prefix.$codePosfix;
        }
        else{

            $lastSample=LabTestSample::whereRaw('SUBSTRING(sample_code, 4, 4)=?',[date('ym')])->where('lab_sample_type_id',$sample_type_id)->latest('created_at')->first();

            if($lastSample){
                $number = substr($lastSample->sample_code ?? null, 7, strlen($lastSample->sample_code ?? null));
                $code= str_replace($number, sprintf('%05d', is_numeric($number)?($number+1):1), $lastSample->sample_code);
            }
            else{
                $code = date('y') . date('m') . sprintf('%05d', 1);
                $code = ($sample_type->prefix??null) . $code;
            }
        }

        return $code;
    }
}
