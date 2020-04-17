<?php

use Illuminate\Support\Facades\Route;

Route::apiResource('products','Pharmacy\ProductsController',[
    //'only'=>['index','show','store','update'],
    'module'=>'acct-mgt',
    'component'=>'receipt'
]);

Route::apiResource('producttypes','Pharmacy\ProductTypeController',[
    //'only'=>['index','show','store','update'],
    'module'=>'acct-mgt',
    'component'=>'receipt'
]);

Route::apiResource('productcategories','Pharmacy\ProductCategoryController',[
    //'only'=>['index','show','store','update'],
    'module'=>'acct-mgt',
    'component'=>'receipt'
]);

Route::apiResource('productforms','Pharmacy\ProductFormController',[
    //'only'=>['index','show','store','update'],
    'module'=>'acct-mgt',
    'component'=>'receipt'
]);

Route::apiResource('productformunits','Pharmacy\ProductFormUnitController',[
    //'only'=>['index','show','store','update'],
    'module'=>'acct-mgt',
    'component'=>'receipt'
]);

Route::apiResource('medicineroutes','Pharmacy\MedicineRouteController',[
    //'only'=>['index','show','store','update'],
    'module'=>'acct-mgt',
    'component'=>'receipt'
]);

