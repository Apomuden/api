<?php

namespace App\Http\Controllers\Utils;
use App\Http\Helpers\FileResolver;
use App\Http\Controllers\Controller;

use Exception;
use Illuminate\Http\Request;

class FileResolverController extends Controller
{
    /* function __construct()
    {
        $this->middleware('auth:api');

    } */
    public function index($path=null,$subdirectory=null){
        try{
            if($path)
           return FileResolver::resolvePage($path,$subdirectory);

        }
        catch(Exception $e){
        }
        return null;
    }

}
