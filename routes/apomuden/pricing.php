<?php

use Illuminate\Support\Facades\Route;

Route::get('fee', 'Pricing\ServiceController@getPrice', [
    'module' => 'config.account',
    'component' => 'config.account.service'
]);
Route::get('services/filter4patient', 'Pricing\ServiceController@getServicesApplicableToPatient', [
    //'only'=>['index','show','store','update'],
    'module' => 'config.account',
    'component' => 'config.account.service'
]);

Route::get('services/page', 'Pricing\ServiceController@page', [
    //'only'=>['index','show','store','update'],
    'module' => 'config.account',
    'component' => 'config.account.service'
]);
Route::apiResource('services', 'Pricing\ServiceController', [
    //'only'=>['index','show','store','update'],
    'module' => 'config.account',
    'component' => 'config.account.service'
]);
