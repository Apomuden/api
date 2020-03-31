<?php
use Illuminate\Support\Facades\Route;

Route::apiResource('ereceipts','Accounts\EreceiptController',[
    //'only'=>['index','show','store','update'],
    'module'=>'acct-mgt',
    'component'=>'receipt'
]);

Route::apiResource('deposits','Accounts\DepositController',[
    //'only'=>['index','show','store','update'],
    'module'=>'acct-mgt',
    'component'=>'deposit'
]);

Route::apiResource('absconds','Accounts\AbscondController',[
    //'only'=>['index','show','store','update'],
    'module'=>'acct-mgt',
    'component'=>'abscond'
]);

Route::apiResource('refunds','Accounts\RefundController',[
    //'only'=>['index','show','store','update'],
    'module'=>'acct-mgt',
    'component'=>'receipt'
]);
