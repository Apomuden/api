<?php
namespace App\Http\Helpers;

use App\Http\Utils\DateFormater;

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
}
