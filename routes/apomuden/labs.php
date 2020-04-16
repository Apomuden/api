<?php
use Illuminate\Support\Facades\Route;
Route::post('services/{service_id}/parameters', 'Pricing\ServiceController@labParametersStore', [
    'module' => ['records-mgt', 'lab-mgt'],
    'component' => 'setup.free.labparameters'
]);
Route::delete('services/{service_id}/parameters', 'Pricing\ServiceController@labParametersDelete', [
    'module' => ['records-mgt', 'lab-mgt'],
    'component' => 'setup.free.labparameters'
]);
Route::get('services/{service_id}/parameters', 'Pricing\ServiceController@labParametersList', [
    'module' => ['records-mgt', 'lab-mgt'],
    'component' => 'setup.free.labparameters'
]);
Route::apiResource('parameters/ranges', 'Lab\LabParameterRangeController', [
    'module' => ['records-mgt', 'lab-mgt'],
    'component' => 'setup.free.labparameters'
]);
Route::apiResource('parameters', 'Lab\LabParameterController', [
    'module' => ['records-mgt', 'lab-mgt'],
    'component' => 'setup.free.labparameters'
]);
