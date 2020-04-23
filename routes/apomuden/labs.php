<?php
use Illuminate\Support\Facades\Route;
Route::post('services/{service_id}/parameters', 'Pricing\ServiceController@labParametersStore', [
    'module' => 'lab-mgt',
    'component' => 'setup.free.labparameters'
]);
Route::delete('services/{service_id}/parameters', 'Pricing\ServiceController@labParametersDelete', [
    'module' => 'lab-mgt',
    'component' => 'setup.free.labparameters'
]);
Route::get('services/{service_id}/parameters', 'Pricing\ServiceController@labParametersList', [
    'module' => 'lab-mgt',
    'component' => 'setup.free.labparameters'
]);
Route::delete('services/{service_id}/sampletypes', 'Pricing\ServiceController@labSampleTypesDelete', [
    'module' => 'lab-mgt',
    'component' => 'setup.free.labparameters'
]);
Route::get('services/{service_id}/sampletypes', 'Pricing\ServiceController@labSampleTypesList', [
    'module' => 'lab-mgt',
    'component' => 'setup.free.labparameters'
]);
Route::post('services/{service_id}/sampletypes', 'Pricing\ServiceController@labSampleTypesStore', [
    'module' => 'lab-mgt',
    'component' => 'setup.free.labparameters'
]);
Route::apiResource('parameters/ranges', 'Lab\LabParameterRangeController', [
    'module' =>'lab-mgt',
    'component' => 'setup.free.labparameters'
]);
Route::apiResource('parameters', 'Lab\LabParameterController', [
    'module' => 'lab-mgt',
    'component' => 'setup.free.labparameters'
]);
Route::get('investigations/{investigation_id}/samplestypes/{sample_type_id}/newcode', 'Lab\LabSampleTypeController@sampleCode', [
    'module' => 'lab-mgt',
    'component' => 'setup.free.labparameters'
]);
Route::apiResource('sampletypes', 'Lab\LabSampleTypeController', [
    'module' => 'lab-mgt',
    'component' => 'setup.free.labparameters'
]);
Route::post('samples/multiple', 'Lab\LabTestSampleController@storeMultiple', [
    'module' => 'lab-mgt',
    'component' => 'labsamples'
]);
Route::apiResource('samples', 'Lab\LabTestSampleController', [
    'module' => 'lab-mgt',
    'component' => 'labsamples'
]);
Route::post('results/multiple', 'Lab\LabTestResultController@storeMultiple', [
    'module' => 'lab-mgt',
    'component' => 'labresults'
]);
Route::apiResource('results', 'Lab\LabTestResultController', [
    'module' => 'lab-mgt',
    'component' => 'labresults'
]);
