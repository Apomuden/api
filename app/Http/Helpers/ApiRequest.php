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
}
