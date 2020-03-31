<?php

namespace App\Http\Helpers;

use Illuminate\Support\Facades\Log;

class FileResolver{
    static public function resolve($url,$subdirectory=null){
        $subdirectory=str_replace('-',DIRECTORY_SEPARATOR,$subdirectory);
        $path=public_path('uploads').DIRECTORY_SEPARATOR.($subdirectory?$subdirectory.DIRECTORY_SEPARATOR:'').$url;
        //Log::notice('photo',[$path]);
        return file_exists ($path)?$path:NULL;
    }
    static public function unlink($prevFile,$currentFile,$uploadDir){
        if($prevFile!=$currentFile){
            $prevFile=FileResolver::resolve($prevFile,$uploadDir);
            if($prevFile)
            unlink($prevFile);
        }
    }
    static public function resolvePage($url,$subdirectory=null){
        return response()->file(self::resolve($subdirectory,$url));
    }
    static public function base64ToFile($fileBase64,$filename=null,$uploadDir=null){

           if(!$fileBase64)
             return null;


            $folderPath =public_path('uploads').DIRECTORY_SEPARATOR.($uploadDir?$uploadDir.DIRECTORY_SEPARATOR:'');

            $file_parts = explode(";base64,", $fileBase64);


            if(count($file_parts)==1)
            return $fileBase64;

            $file_type_aux =explode("/", $file_parts[0]);

            //$file_type = $file_type_aux[1];

            $file_base64 = base64_decode($file_parts[1]);

            $file=($filename??uniqid()) . '.'.trim($file_type_aux[1]);
            $full_path = $folderPath . $file;

            file_put_contents($full_path,$file_base64);

            return $file;
    }
    static function data2excel($records,$caption=NULL)
    {
        $heading = false;
        if($caption!=NULL)
        echo strtoupper($caption)."\t\n";

        if(!empty($records))
          foreach($records as $row) {
        if(!$heading) {
          // display field/column names as a first row
          echo implode("\t", array_keys((array)$row)) . "\n";
          $heading = true;
        }
        echo implode("\t", array_values((array)$row)) . "\n";
       }
        exit;
    }
}
