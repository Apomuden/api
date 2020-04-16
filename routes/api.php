<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::group(['prefix' => 'v1'], function () {

//Main Dashboard
Route::group(['prefix' => 'dashboard'], function () {
     Route::get('staffcategories',[
         'uses'=>'Summaries\StaffCategoryController@index',
         'as'=>'dashboard.summaries.view',
         'module'=>'dasboard',
         'component'=>'dasboard.staffcategories'
     ]);
});
//Auth Routes
Route::prefix('auth')->group(base_path('routes/apomuden/users.php'));

//Authenticated Routes
    Route::group(['middleware'=>['role.auth']],function () {
        //Pricing
        Route::prefix('pricing')->group(base_path('routes/apomuden/pricing.php'));

        //Accounts
        Route::prefix('accounts')->group(base_path('routes/apomuden/accounts.php'));

        //Registrations
        Route::prefix('registry')->group(base_path('routes/apomuden/registry.php'));

        //Setups
        Route::prefix('setups')->group(base_path('routes/apomuden/setups.php'));

        //Pharmacy
        Route::prefix('pharmacy')->group(base_path('routes/apomuden/pharmacy.php'));
    });
  Route::group(['prefix' => 'utils'], function () {
    //FileResolver
   Route::get('file/{subdirectory?}/{path}',[
       'uses'=> 'Utils\FileResolverController@index',
       'as'=> 'file.url',
       'module' => null,
       'component' => null
    ]);
  });
});
