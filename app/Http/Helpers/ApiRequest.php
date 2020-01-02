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
}
