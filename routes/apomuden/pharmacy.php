<?php

use Illuminate\Support\Facades\Route;

Route::apiResource('products','Pharmacy\ProductsController',[
    //'only'=>['index','show','store','update'],
    'module'=>null,
    'component'=>'products'
]);
Route::apiResource('producttypes','Pharmacy\ProductTypeController',[
    //'only'=>['index','show','store','update'],
    'module'=>null,
    'component'=>'producttypes'
]);
Route::apiResource('productcategories','Pharmacy\ProductCategoryController',[
    //'only'=>['index','show','store','update'],
    'module'=>null,
    'component'=>'productcategories'
]);
Route::apiResource('productforms','Pharmacy\ProductFormController',[
    //'only'=>['index','show','store','update'],
    'module'=>null,
    'component'=>'productforms'
]);
Route::apiResource('productformunits','Pharmacy\ProductFormUnitController',[
    //'only'=>['index','show','store','update'],
    'module'=>null,
    'component'=>'productformunits'
]);
Route::apiResource('medicineroutes','Pharmacy\MedicineRouteController',[
    //'only'=>['index','show','store','update'],
    'module'=>null,
    'component'=>'medicineroutes'
]);
