<?php
use Illuminate\Support\Facades\Route;

Route::apiResource('family_information','Obstetrics\ObsFamilyInformationController',[
    'module'=> 'obstetric',
    'component'=> 'obstetric.family.information'
]);

Route::apiResource('obstetric_histories','Obstetrics\ObstetricHistoryController',[
    'module'=> 'obstetric',
    'component'=> 'obstetric.history'
]);

Route::apiResource('previous_pregnancies','Obstetrics\PreviousPregnancyController',[
    'module'=> 'obstetric',
    'component'=> 'obstetric.pregancy.record'
]);

Route::apiResource('delivery_modes','Obstetrics\DeliveryModeController',[
    'module'=> 'config.obstetric',
    'component'=> 'config.obstetric.delivery.modes'
]);

Route::apiResource('delivery_outcomes','Obstetrics\DeliveryOutcomeController',[
    'module'=> 'config.obstetric',
    'component'=> 'config.obstetric.delivery.outcomes'
]);

Route::apiResource('birth_places','Obstetrics\ObsBirthPlaceController',[
    'module'=> 'config.obstetric',
    'component'=> 'config.obstetric.birth.places'
]);

Route::apiResource('gestational_weeks','Obstetrics\GestationalWeekController',[
    'module'=> 'config.obstetric',
    'component'=> 'config.obstetric.gestation'
]);

Route::post('questions/multiple', 'Obstetrics\ObstetricQuestionController@storeMultiple');
Route::apiResource('questions','Obstetrics\ObstetricQuestionController',[
    'module'=> 'config.obstetric',
    'component'=> 'config.obstetric.questionaire'
]);

Route::get('consultation/question_responses', 'Obstetrics\ObstetricQuestionResponseController@showConsultGroupedResponses');
Route::get('consultation/question_responses/{id}', 'Obstetrics\ObstetricQuestionResponseController@showConsultResponses');
Route::post('question_responses/multiple', 'Obstetrics\ObstetricQuestionResponseController@storeMultiple');
Route::apiResource('question_responses','Obstetrics\ObstetricQuestionResponseController',[
    'module' => 'config.obstetric',
    'component' => 'config.obstetric.questionaire'
]);

Route::apiResource('question_options','Obstetrics\ObstetricQuestionOptionController',[
    'module' => 'config.obstetric',
    'component' => 'config.obstetric.questionaire'
]);
