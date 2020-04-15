<?php
use Illuminate\Support\Facades\Route;
Route::apiResource('parameters', 'Lab\LabParameterController', [
    'module' => ['records-mgt', 'lab-mgt'],
    'component' => 'setup.free.labparameters'
]);
