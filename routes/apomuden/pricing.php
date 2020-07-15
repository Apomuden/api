<?php
use Illuminate\Support\Facades\Route;

Route::apiResource('services','Pricing\ServiceController',[
    //'only'=>['index','show','store','update'],
    'module'=> 'config.account',
    'component'=> 'config.account.service'
]);
