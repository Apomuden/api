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
Route::apiResource('parameters/ranges', 'Lab\LabParameterRangeController', [
    'module' =>'lab-mgt',
    'component' => 'setup.free.labparameters'
]);
Route::apiResource('parameters', 'Lab\LabParameterController', [
    'module' => 'lab-mgt',
    'component' => 'setup.free.labparameters'
]);
Route::apiResource('sampletypes', 'Lab\LabSampleTypeController', [
    'module' => 'lab-mgt',
    'component' => 'setup.free.labparameters'
]);
