<?php

use Illuminate\Support\Facades\Route;

Route::get('patients/paginated', [
    'uses' => 'Registration\PatientController@paginated',
    'as' => 'patients.paginated.view',
    'module' => 'record',
    'component' => 'record.patient'
]);
//Patients Route
Route::post('patients/withfolder', [
    'uses' => 'Registration\PatientController@storePatientWithFolder',
    'as' => 'patients.withfolder',
    'module' => 'record',
    'component' => 'record.patient'
]);

Route::get('patients/single', [
    'uses' => 'Registration\PatientController@findByFolder',
    'as' => 'patients.single.view',
    //'module' => 'records-mgt',
    //'component' => 'patient-registry'
]);
Route::apiResource('patients', 'Registration\PatientController', [
    //'only'=>['index','show','store','update'],
    'module' => 'record',
    'component' => 'record.patient'
]);

Route::post('patientsponsors/multiple',[
    'uses'=> 'Registration\PatientSponsorController@storeMultiple',
    'as'=>'patients.multiple.view',
    'module' => 'record',
    'component' => 'record.sponsorship.permit'
]);
Route::apiResource('patientsponsors', 'Registration\PatientSponsorController', [
    'module' => 'record',
    'component' => 'record.sponsorship.permit'
]);

Route::apiResource('sponsorshiprenewals', 'Registration\SponsorshipRenewalController', [
    'module' => 'record',
    'component' => 'record.sponsorship.permit'
]);

Route::apiResource('folders', 'Registration\FolderController', [
    //'only'=>['index','show','store','update'],
    'module' => 'record',
    'component' => 'record.folder'
]);
Route::apiResource('patientnextofkins', 'Registration\PatientNextOfKinController', [
    //'only'=>['index','show','store','update'],
    'module' => 'record',
    'component' => 'record.patient'
]);
Route::get('consultations/{consultant_id}/queue', 'Registration\ConsultationController@getInitialQueue',[
    //'only'=>['index','show','store','update'],
    //'module'=>'records-mgt',
    //'component'=> 'patient-registry'
]);
Route::apiResource('consultations','Registration\ConsultationController',[
    //'only'=>['index','show','store','update'],
    'module'=>'record',
    'component'=> 'record.request.consultation'
]);
Route::apiResource('patienthistories', 'Registration\PatientHistoryController',[
    //'only'=>['index','show','store','update'],
    'module' => 'record',
    'component' => 'record.patient'
]);
Route::apiResource('patienthistorysummaries', 'Registration\PatientHistoriesSummaryController',[
    //'only'=>['index','show','store','update'],
    'module' => 'record',
    'component' => 'record.patient'
]);
Route::post('physicalexaminations/multiple', 'Registration\PhysicalExaminationController@storeMultiple',[
    //'only'=>['index','show','store','update'],
    'module' => 'record',
    'component' => 'record.request.consultation'
]);

Route::apiResource('physicalexaminations', 'Registration\PhysicalExaminationController',[
    //'only'=>['index','show','store','update'],
    'module' => 'record',
    'component' => 'record.request.consultation'
]);

Route::post('diagnoses/multiple', 'Registration\DiagnosisController@storeMultiple', [
    //'only'=>['index','show','store','update'],
    'module' => 'record',
    'component' => 'record.request.consultation'
]);
Route::apiResource('diagnoses', 'Registration\DiagnosisController',[
    //'only'=>['index','show','store','update'],
    'module' => 'record',
    'component' => 'record.request.consultation'
]);

Route::post('investigations/multiple', 'Registration\InvestigationController@storeMultiple', [
    //'only'=>['index','show','store','update'],
    'module' => 'record',
    'component' => 'record.request.consultation'
]);

Route::apiResource('investigations', 'Registration\InvestigationController',[
    //'only'=>['index','show','store','update'],
    'module' => 'record',
    'component' => 'record.request.consultation'
]);
Route::post('procedures/multiple', 'Registration\ProcedureController@storeMultiple',[
    //'only'=>['index','show','store','update'],
    'module' => 'record',
    'component' => 'record.request.consultation'
]);
Route::apiResource('procedures', 'Registration\ProcedureController',[
    //'only'=>['index','show','store','update'],
    'module' => 'record',
    'component' => 'record.request.consultation'
]);
Route::apiResource('consultingrooms', 'Registration\ConsultingRoomController',[
    'module'=> 'facility',
    'component' => 'facility.consultation.rooms'
]);

Route::apiResource('consultationservicerequests', 'Registration\ConsultationController',[
    //'only'=>['index','show','store','update'],
    'module' => ['record','clinical'],
    'component' => 'record.request.consultation'
]);
Route::get('attendance/byfolder', 'Registration\AttendanceController@byFolderNo');
Route::apiResource('attendance', 'Registration\AttendanceController',[
    //'only'=>['index','show','store','update'],
    //'module'=>['records-mgt','sys-mgt'],
    //'component'=> 'patient-registry'
]);
Route::apiResource('serviceorders', 'Pricing\ServiceOrderController',[
    //'module' => ['records-mgt', 'sys-mgt'],
    //'component' => 'config.account.service'
]);
Route::apiResource('appointments', 'Registration\AppointmentController',[
    //'only'=>['index','show','store','update'],
    'module'=>'record',
    'component'=> 'record.appointment'
]);
Route::get('patientvitals/byattendancedate/{attendanceDate}', 'Registration\PatientVitalController@byAttendanceDate');
Route::apiResource('patientvitals', 'Registration\PatientVitalController',[
    //'only'=>['index','show','store','update'],
    'module'=>'opd',
    'component'=> 'opd.vital'
]);
Route::put('consultationquestionresponses/{id}', 'Registration\ConsultationQuestionResponsesController@update');
Route::get('consultation/questionresponses/{id}', 'Registration\ConsultationQuestionResponsesController@showConsultResponses');
Route::get('consultation/questionresponses', 'Registration\ConsultationQuestionResponsesController@showConsultGroupedResponses');
Route::apiResource('consultationquestionresponses', 'Registration\ConsultationQuestionResponsesController', [
    'module' => ['record', 'clinical'],
    'component' => 'record.request.consultation'
]);
