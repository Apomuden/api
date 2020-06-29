<?php
use Illuminate\Support\Facades\Route;

Route::apiResource('family_information','Obstetrics\ObsFamilyInformationController',[
    'module'=>'obs-mgt',
    'component'=>'preg-rec'
]);

Route::apiResource('obstetric_histories','Obstetrics\ObstetricHistoryController',[
    'module'=>'obs-mgt',
    'component'=>'preg-rec'
]);

Route::apiResource('previous_pregnancies','Obstetrics\PreviousPregnancyController',[
    'module'=>'obs-mgt',
    'component'=>'preg-rec'
]);

Route::apiResource('delivery_modes','Obstetrics\DeliveryModeController',[
    'module'=>'obs-mgt',
    'component'=>'preg-rec'
]);

Route::apiResource('delivery_outcomes','Obstetrics\DeliveryOutcomeController',[
    'module'=>'obs-mgt',
    'component'=>'preg-rec'
]);

Route::apiResource('birth_places','Obstetrics\ObsBirthPlaceController',[
    'module'=>'obs-mgt',
    'component'=>'preg-rec'
]);

Route::apiResource('gestational_weeks','Obstetrics\GestationalWeekController',[
    'module'=>'obs-mgt',
    'component'=>'preg-rec'
]);

Route::post('questions/multiple', 'Obstetrics\ObstetricQuestionController@storeMultiple');
Route::apiResource('questions','Obstetrics\ObstetricQuestionController',[
    'module'=>'obs-mgt',
    'component'=>'preg-rec'
]);

Route::get('consultation/question_responses', 'Obstetrics\ObstetricQuestionResponseController@showConsultGroupedResponses');
Route::get('consultation/question_responses/{id}', 'Obstetrics\ObstetricQuestionResponseController@showConsultResponses');
Route::post('question_responses/multiple', 'Obstetrics\ObstetricQuestionResponseController@storeMultiple');
Route::apiResource('question_responses','Obstetrics\ObstetricQuestionResponseController',[
    'module'=>'obs-mgt',
    'component'=>'preg-rec'
]);

Route::apiResource('question_options','Obstetrics\ObstetricQuestionOptionController',[
    'module'=>'obs-mgt',
    'component'=>'preg-rec'
]);
