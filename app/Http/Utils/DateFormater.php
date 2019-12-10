<?php
namespace App\Http\Utils;

use App\Models\Hospital;
use App\Models\User;
use Carbon\Carbon;

class DateFormater {
    public function __construct(String $date,String $displayDateFormat="d-m-Y",String $displayDateTimeFormat="d-m-Y H:i:s")
    {
       $this->time=strtotime(strpos('/',$date)!==-1?str_replace('/','-',$date):(new Carbon($date))->isoFormat('D-M-Y H:m:s'));
       $this->displayDateFormat=$displayDateFormat;
       $this->displayDateTimeFormat=$displayDateTimeFormat;
    }
    function toDisplayDate(){
       return date($this->displayDateFormat,$this->time);
    }
    function toDBDate(){
        return date('Y-m-d',$this->time);
     }
    function toDisplayDateTime(){
        return date($this->displayDateTimeFormat,$this->time);
    }
    function toDBDateTime(){
        return date('Y-m-d H:i:s',$this->time);
     }
}
