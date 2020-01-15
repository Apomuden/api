<?php
use Illuminate\Support\Facades\Route;

Route::get('patients/paginated',[
    'uses'=>'Registration\PatientController@paginated',
    'as'=>'patients.paginated.view',
    'module'=>'records-mgt',
    'component'=>'patient-registry'
]);
Route::apiResource('patients','Registration\PatientController',[
    //'only'=>['index','show','store','update'],
    'module'=>'records-mgt',
    'component'=>'patient-registry'
]);
Route::apiResource('folders','Registration\FolderController',[
    //'only'=>['index','show','store','update'],
    'module'=>'records-mgt',
    'component'=>'patient-registry'
]);
Route::apiResource('patientnextofkins','Registration\PatientNextOfKinController',[
    //'only'=>['index','show','store','update'],
    'module'=>'records-mgt',
    'component'=>'patient-registry'
]);
