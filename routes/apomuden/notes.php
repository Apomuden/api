<?php

use Illuminate\Support\Facades\Route;

Route::apiResource('admissionnotes', 'Registration\LabTestResultController', [
    'module' => 'ipd-mgt',
    'component' => 'ipd-clinical-notes'
]);

Route::apiResource('deliverynotes', 'Registration\DeliveryNoteController', [
    'module' => 'ipd-mgt',
    'component' => 'ipd-clinical-notes'
]);

Route::apiResource('nursingnotes', 'Registration\NursingNoteController', [
    'module' => 'ipd-mgt',
    'component' => 'ipd-clinical-notes'
]);

Route::apiResource('physiciannotes', 'Registration\PhysicianNoteController', [
    'module' => 'ipd-mgt',
    'component' => 'ipd-clinical-notes'
]);

Route::apiResource('procedurenotes', 'Registration\ProcedureNoteController', [
    'module' => 'ipd-mgt',
    'component' => 'ipd-clinical-notes'
]);

Route::apiResource('progressnotes', 'Registration\ProgressNoteController', [
    'module' => 'ipd-mgt',
    'component' => 'ipd-clinical-notes'
]);

Route::apiResource('treatmentplannotes', 'Registration\TreatmentPlanController', [
    'module' => 'ipd-mgt',
    'component' => 'ipd-clinical-notes'
]);

Route::apiResource('urgentcarenotes', 'Registration\UrgentCareNoteController', [
    'module' => 'ipd-mgt',
    'component' => 'ipd-clinical-notes'
]);
