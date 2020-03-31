<?php

use Illuminate\Support\Facades\Route;

Route::get('patients/paginated', [
    'uses' => 'Registration\PatientController@paginated',
    'as' => 'patients.paginated.view',
    'module' => 'records-mgt',
    'component' => 'patient-registry'
]);
//Patients Route
Route::post('patients/withfolder', [
    'uses' => 'Registration\PatientController@storePatientWithFolder',
    'as' => 'patients.withfolder',
    'module' => 'records-mgt',
    'component' => 'patient-registry'
]);

Route::get('patients/single', [
    'uses' => 'Registration\PatientController@findByFolder',
    'as' => 'patients.single.view',
    'module' => 'records-mgt',
    'component' => 'patient-registry'
]);
Route::apiResource('patients', 'Registration\PatientController', [
    //'only'=>['index','show','store','update'],
    'module' => 'records-mgt',
    'component' => 'patient-registry'
]);

Route::post('patientsponsors/multiple',[
    'uses'=> 'Registration\PatientSponsorController@storeMultiple',
    'as'=>'patients.multiple.view',
    'module' => 'records-mgt',
    'component' => 'patient-registry'
]);
Route::apiResource('patientsponsors', 'Registration\PatientSponsorController', [
    'module' => 'records-mgt',
    'component' => 'patient-registry'
]);

Route::apiResource('sponsorshiprenewals', 'Registration\SponsorshipRenewalController', [
    'module' => 'records-mgt',
    'component' => 'patient-registry'
]);

Route::apiResource('folders', 'Registration\FolderController', [
    //'only'=>['index','show','store','update'],
    'module' => 'records-mgt',
    'component' => 'patient-registry'
]);
Route::apiResource('patientnextofkins', 'Registration\PatientNextOfKinController', [
    //'only'=>['index','show','store','update'],
    'module' => 'records-mgt',
    'component' => 'patient-registry'
]);
Route::get('consultations/{consultant_id}/queue', 'Registration\ConsultationController@getInitialQueue',[
    //'only'=>['index','show','store','update'],
    'module'=>'records-mgt',
    'component'=> 'patient-registry'
]);
Route::apiResource('consultations','Registration\ConsultationController',[
    //'only'=>['index','show','store','update'],
    'module'=>'records-mgt',
    'component'=> 'patient-registry'
]);
Route::apiResource('patienthistories', 'Registration\PatientHistoryController',[
    //'only'=>['index','show','store','update'],
    'module'=>'records-mgt',
    'component'=> 'patient-registry'
]);
Route::post('physicalexaminations/multiple', 'Registration\PhysicalExaminationController@storeMultiple',[
    //'only'=>['index','show','store','update'],
    'module'=>'records-mgt',
    'component'=> 'patient-registry'
]);
Route::apiResource('physicalexaminations', 'Registration\PhysicalExaminationController',[
    //'only'=>['index','show','store','update'],
    'module'=>'records-mgt',
    'component'=> 'patient-registry'
]);

Route::apiResource('consultingrooms', 'Registration\ConsultingRoomController',[
    'module'=> 'records-mgt',
    'component' => 'patient-registry'
]);

Route::apiResource('consultationservicerequests', 'Registration\ConsultationController',[
    //'only'=>['index','show','store','update'],
    'module'=>['records-mgt','sys-mgt'],
    'component'=> 'patient-registry'
]);
Route::get('attendance/byfolder', 'Registration\AttendanceController@byFolderNo');
Route::apiResource('attendance', 'Registration\AttendanceController',[
    //'only'=>['index','show','store','update'],
    'module'=>['records-mgt','sys-mgt'],
    'component'=> 'patient-registry'
]);
Route::apiResource('serviceorders', 'Pricing\ServiceOrderController',[
    'module' => ['records-mgt', 'sys-mgt'],
    'component' => 'patient-registry'
]);

Route::apiResource('appointments', 'Registration\AppointmentController',[
    //'only'=>['index','show','store','update'],
    'module'=>['records-mgt','sys-mgt'],
    'component'=> 'patient-registry'
]);

Route::get('patientvitals/byattendancedate', 'Registration\PatientVitalController@byAttendanceDate');
Route::apiResource('patientvitals', 'Registration\PatientVitalController',[
    //'only'=>['index','show','store','update'],
    'module'=>['records-mgt','sys-mgt'],
    'component'=> 'patient-registry'
]);
