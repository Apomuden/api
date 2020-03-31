<?php
namespace App\Http\Helpers;
use Illuminate\Http\Request;


class ApiRequest{
    static function asArray(Request $request){
       return $request->json()->all()?$request->json()->all():$request->all();
    }

    static function asObject(Request $request){
       return (object) self::asArray($request);
     }

     static function sanitize_string($string){
            $string = strip_tags($string);
            $string = addslashes($string);
            return filter_var($string, FILTER_SANITIZE_STRING);
     }
     static function startsWith($string, $start)
     {
        return strrpos($string, $start, -strlen($string)) !== false;
     }

     static function endsWith($string, $end)
    {
        return ($offset = strlen($string) - strlen($end)) >= 0
            && strpos($string, $end, $offset) !== false;
    }
}
