<?php

use Illuminate\Support\Facades\Route;

Route::apiResource('admissionnotes', 'Registration\AdmissionNoteController', [
    'module' => 'clinical',
    'component' => 'clinical.note.admission'
]);

Route::apiResource('deliverynotes', 'Registration\DeliveryNoteController', [
    'module' => 'clinical',
    'component' => 'clinical.note.delivery'
]);

Route::apiResource('nursingnotes', 'Registration\NursingNoteController', [
    'module' => 'clinical',
    'component' => 'clinical.note.nursing'
]);

Route::apiResource('physiciannotes', 'Registration\PhysicianNoteController', [
    'module' => 'clinical',
    'component' => 'clinical.note.physician'
]);

Route::apiResource('procedurenotes', 'Registration\ProcedureNoteController', [
    'module' => 'clinical',
    'component' => 'clinical.note.procurement'
]);

Route::apiResource('progressnotes', 'Registration\ProgressNoteController', [
    'module' => 'clinical',
    'component' => 'clinical.note.progress'
]);

Route::apiResource('treatmentplannotes', 'Registration\TreatmentPlanController', [
    'module' => 'clinical',
    'component' => 'clinical.note.treatment.plan'
]);

Route::apiResource('urgentcarenotes', 'Registration\UrgentCareNoteController', [
    'module' => 'clinical',
    'component' => 'clinical.note.urgent.care'
]);

Route::apiResource('patientnotesummaries','Registration\PatientNoteSummaryController',[
    'except' => ['store', 'update'],
    //'module' => 'ipd-mgt',
    //'component' => 'ipd-clinical-notes'
]);
