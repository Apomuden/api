<?php
use Illuminate\Support\Facades\Route;

Route::apiResource('serviceprices','Pricing\ServicePricingController',[
    //'only'=>['index','show','store','update'],
    'module'=>['records-mgt','sys-mgt'],
    'component'=>'setup.serviceprices'
]);
