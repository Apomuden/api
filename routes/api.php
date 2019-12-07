<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/* Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
}); */


Route::group(['prefix' => 'v1'], function () {
//Auth Routes
Route::group(['prefix' => 'auth'], function () {
    Route::post('login', 'Auth\AccessController@login')->name('auth.login');
    Route::post('logout', 'Auth\AccessController@logout')->name('auth.logout');
    Route::get('/refresh', 'Auth\AccessController@refresh')->name('auth.refresh');
});

  //Authenticated Routes
  Route::group(['middleware'=>['jwt.auth']],function () {
    //Setups
    Route::group(['prefix' => 'setups'], function () {
        Route::apiResource('countries','Setups\CountryController',['only'=>['index','show']]);
        Route::apiResource('accreditations','Setups\accreditationController',['only'=>['index','show','store']]);
    });
    Route::group(['prefix' => 'utils'], function () {
        //FileResolver
       Route::get('file/{subdirectory?}/{path}','Utils\FileResolverController@index')->name('file.url');
    });
  });
});
