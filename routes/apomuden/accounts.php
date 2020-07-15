<?php
use Illuminate\Support\Facades\Route;

Route::apiResource('ereceipts','Accounts\EreceiptController',[
    //'only'=>['index','show','store','update'],
    'module'=>'account',
    'component'=> 'account.patient.payment'
]);

Route::apiResource('deposits','Accounts\DepositController',[
    //'only'=>['index','show','store','update'],
    'module' => 'account',
    'component' => 'account.patient.deposit'
]);

Route::apiResource('discounts','Accounts\DiscountController',[
    //'only'=>['index','show','store','update'],
    'module' => 'account',
    'component'=> 'account.patient.discount'
]);

Route::apiResource('absconds','Accounts\AbscondController',[
    //'only'=>['index','show','store','update'],
    'module'=>'account',
    'component'=> 'account.patient.abscond'
]);

Route::apiResource('refunds','Accounts\RefundController',[
    //'only'=>['index','show','store','update'],
    'module' => 'account',
    'component'=> 'account.patient.refund'
]);

Route::get('transactions/patients/{patient_id}/quickdetails','Accounts\TransactionController@quickDetails');
Route::post('transactions/ereceipt','Accounts\TransactionController@createReceipt');
