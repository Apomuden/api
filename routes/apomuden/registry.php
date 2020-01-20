<?php
use Illuminate\Support\Facades\Route;

Route::get('patients/paginated',[
    'uses'=>'Registration\PatientController@paginated',
    'as'=>'patients.paginated.view',
    'module'=>'records-mgt',
    'component'=>'patient-registry'
]);
//Patients Route
Route::post('patients/withfolder',[
    'uses'=> 'Registration\PatientController@storePatientWithFolder',
    'as'=>'patients.withfolder',
    'module' => 'records-mgt',
    'component' => 'patient-registry'
]);

Route::get('patients/single', [
    'uses' => 'Registration\PatientController@findByFolder',
    'as' => 'patients.single.view',
    'module' => 'records-mgt',
    'component' => 'patient-registry'
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
