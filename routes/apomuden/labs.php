<?php
use Illuminate\Support\Facades\Route;
Route::post('services/{service_id}/parameters', 'Pricing\ServiceController@labParametersStore', [
    'module' => 'config.lab',
    'component' => 'config.lab.parameter'
]);
Route::delete('services/{service_id}/parameters', 'Pricing\ServiceController@labParametersDelete', [
    'module' => 'config.lab',
    'component' => 'config.lab.parameter'
]);
Route::get('services/{service_id}/parameters', 'Pricing\ServiceController@labParametersList', [
    'module' => 'config.lab',
    'component' => 'config.lab.parameter'
]);
Route::delete('services/{service_id}/sampletypes', 'Pricing\ServiceController@labSampleTypesDelete', [
    'module' => 'config.lab',
    'component' => 'config.lab.sample.type'
]);
Route::get('services/{service_id}/sampletypes', 'Pricing\ServiceController@labSampleTypesList', [
    'module' => 'config.lab',
    'component' => 'config.lab.sample.type'
]);
Route::post('services/{service_id}/sampletypes', 'Pricing\ServiceController@labSampleTypesStore', [
    'module' => 'config.lab',
    'component' => 'config.lab.sample.type'
]);
Route::apiResource('parameters/ranges', 'Lab\LabParameterRangeController', [
    'module' => 'config.lab',
    'component' => 'config.lab.parameter'
]);
Route::apiResource('parameters', 'Lab\LabParameterController', [
    'module' => 'config.lab',
    'component' => 'config.lab.parameter'
]);
Route::get('investigations/{investigation_id}/samplestypes/{sample_type_id}/newcode', 'Lab\LabSampleTypeController@sampleCode', [
    //'module' => 'lab-mgt',
    //'component' => 'setup.free.labparameters'
]);
Route::get('investigations/{investigation_id}/results', 'Registration\InvestigationController@hierarchyShow', [
    //'only'=>['index','show','store','update'],
    //'module' => 'lab-mgt',
    //'component' => 'setup.free.labparameters'
]);
Route::get('investigations/results', 'Registration\InvestigationController@hierarchyIndex', [
    //'only'=>['index','show','store','update'],
    //'module' => 'records-mgt',
    //'component' => 'patient-registry'
]);

Route::apiResource('sampletypes', 'Lab\LabSampleTypeController', [
    'module' => 'config.lab',
    'component' => 'config.lab.sample.type'
]);
Route::post('samples/multiple', 'Lab\LabTestSampleController@storeMultiple', [
    'module' => 'lab',
    'component' => 'lab.sample'
]);
Route::apiResource('samples', 'Lab\LabTestSampleController', [
    'module' => 'lab',
    'component' => 'lab.sample'
]);
Route::post('results/multiple', 'Lab\LabTestResultController@storeMultiple', [
    'module' => 'lab',
    'component' => 'lab.result'
]);
Route::apiResource('results', 'Lab\LabTestResultController', [
    'module' => 'lab',
    'component' => 'lab.result'
]);
