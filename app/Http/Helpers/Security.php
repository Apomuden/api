<?php
namespace App\Http\Helpers;

use Illuminate\Support\Facades\Hash;

class Security{
    static function confirmPassword($plain_password,$hash_password,$id){
      return Hash::check(trim($plain_password).trim($id),trim($hash_password));
    }

    static function getNewPasswordHash($plain_password,$id){
       return Hash::make(trim($plain_password).trim($id));
    }
}
