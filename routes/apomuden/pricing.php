<?php
use Illuminate\Support\Facades\Route;

Route::apiResource('services','Pricing\ServiceController',[
    //'only'=>['index','show','store','update'],
    'module'=>['records-mgt','sys-mgt'],
    'component'=>'setup.serviceprices'
]);
