<?php

use Illuminate\Support\Facades\Route;

Route::apiResource('products','Pharmacy\ProductsController',[
    //'only'=>['index','show','store','update'],
    'module'=>'config.store',
    'component'=> 'config.store.product'
]);
Route::apiResource('producttypes','Pharmacy\ProductTypeController',[
    //'only'=>['index','show','store','update'],
    'module'=> 'config.store',
    'component'=> 'config.store.product.type.category'
]);
Route::apiResource('productcategories','Pharmacy\ProductCategoryController',[
    //'only'=>['index','show','store','update'],
    'module' => 'config.store',
    'component' => 'config.store.product.type.category'
]);
Route::apiResource('productforms','Pharmacy\ProductFormController',[
    //'only'=>['index','show','store','update'],
    'module' => 'config.store',
    'component' => 'config.store.product.form.unit'
]);
Route::apiResource('productformunits','Pharmacy\ProductFormUnitController',[
    //'only'=>['index','show','store','update'],
    'module'=> 'config.store',
    'component'=> 'config.store.product.form.unit'
]);
Route::apiResource('medicineroutes','Pharmacy\MedicineRouteController',[
    //'only'=>['index','show','store','update'],
    'module'=> 'config.store',
    'component'=> 'config.store.medicine.route'
]);

Route::apiResource('stores','Pharmacy\StoreController',[
    //'only'=>['index','show','store','update'],
    'module'=> 'config.store',
    'component'=> 'config.store.store'
]);

Route::apiResource('storeactivities','Pharmacy\StoreActivityController',[
    //'only'=>['index','show','store','update'],
    //'module'=>null,
    //'component'=>'storeactivities'
]);

Route::apiResource('storeusers','Pharmacy\StoreUserController',[
    //'only'=>['index','show','store','update'],
    'module'=> 'config.store',
    'component'=> 'config.store.users'
]);


Route::post('stockadjustments/approvals','Pharmacy\StockAdjustmentController@approve');
Route::get('stockadjustments/approvals','Pharmacy\StockAdjustmentController@getApprovals');
Route::apiResource('stockadjustments','Pharmacy\StockAdjustmentController',[
    //'only'=>['index','show','store','update'],
    'module'=>'account',
    'component'=> 'account.stock.adjustment'
]);

Route::post('requisitions/approvals','Pharmacy\RequisitionController@approve');
Route::get('requisitions/approvals','Pharmacy\RequisitionController@getApprovals');
Route::apiResource('requisitions','Pharmacy\RequisitionController',[
    //'only'=>['index','show','store','update'],
    'module'=>'account',
    'component'=> 'account.requisition'
]);
