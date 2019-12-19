<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::group(['prefix' => 'v1'], function () {
//Auth Routes
Route::group(['prefix' => 'auth'], function () {
    Route::post('login', 'Auth\AccessController@login')->name('auth.login');
    Route::post('logout', 'Auth\AccessController@logout')->name('auth.logout');
    Route::get('/refresh', 'Auth\AccessController@refresh')->name('auth.refresh');

      //Authenticated Auth Routes
    Route::group(['middleware'=>['jwt.auth']], function () {
        Route::apiResource('roles','Setups\RoleController',['only'=>['index','show','store','update']]);
        Route::apiResource('permissions','Setups\PermissionController',['only'=>['index','show','update']]);
        Route::group(['prefix' => 'profile'], function () {
            Route::match(['PUT', 'PATCH'],'update','Auth\ProfileController@update')->name('profile.update');
        });
    });
});

  //Authenticated Routes
  Route::group(['middleware'=>['jwt.auth']],function () {
    //Setups
    Route::group(['prefix' => 'setups'], function () {
        Route::apiResource('countries','Setups\CountryController',['only'=>['index','show']]);

        Route::get('districts/{district}/towns','Setups\TownController@showByDistrict')->name('district.towns.show');
        Route::apiResource('towns','Setups\TownController',['only'=>['index','show','store','update']]);

        Route::get('countries/{country}/regions','Setups\RegionController@showByCountry')->name('country.regions.show');
        Route::apiResource('regions','Setups\RegionController',['only'=>['index','show']]);
        Route::get('regions/{region}/districts','Setups\DistrictController@showByRegion')->name('region.districts.show');
        Route::apiResource('districts','Setups\DistrictController',['only'=>['index','show','store','update']]);
        Route::apiResource('accreditations','Setups\AccreditationController',['only'=>['index','show','store','update']]);
        Route::get('hospital','Setups\HospitalController@show')->name('hospital.show');
        Route::post('hospital','Setups\HospitalController@store')->name('hospital.store');
        Route::match(['PUT', 'PATCH'], 'hospital','Setups\HospitalController@update')->name('hospital.update');

        Route::apiResource('religions','Setups\ReligionController',['only'=>['index','show','store','update']]);
        Route::apiResource('relationships','Setups\RelationshipController',['only'=>['index','show','store','update']]);

        Route::get('gender/{gender}/titles','Setups\TitleController@showByGender')->name('gender.titles.show');
        Route::apiResource('titles','Setups\TitleController',['only'=>['index','show','store','update']]);
        Route::apiResource('departments','Setups\DepartmentController',['only'=>['index','show','store','update']]);
        Route::apiResource('agegroups','Setups\AgeGroupController',['only'=>['index','show','store','update']]);
        Route::apiResource('educationallevels','Setups\EducationalLevelController',['only'=>['index','show','store','update']]);
        Route::apiResource('idtypes','Setups\IDTypeController',['only'=>['index','show','store','update']]);
        Route::apiResource('banks','Setups\BankController',['only'=>['index','show','store','update']]);

        Route::get('banks/{bank}/branches','Setups\BankBranchController@showByBank')->name('bank.branches.show');
        Route::apiResource('bankbranches','Setups\BankBranchController',['only'=>['index','show','store','update']]);
        Route::apiResource('languages','Setups\LanguageController',['only'=>['index','show','store','update']]);
        Route::apiResource('staffcategories','Setups\StaffCategoryController',['only'=>['index','show','store','update']]);
        Route::get('staffcategories/{staffcategory}/professions','Setups\ProfessionController@showByCategory')->name('staffcategory.professions.show');
        Route::apiResource('professions','Setups\ProfessionController',['only'=>['index','show','store','update']]);
        Route::apiResource('stafftypes','Setups\StaffTypeController',['only'=>['index','show','store','update']]);

        Route::apiResource('hospitalservices','Setups\HospitalServiceController',['only'=>['index','show','store','update']]);
        Route::apiResource('billingcycles','Setups\BillingCycleController',['only'=>['index','show','store','update']]);
        Route::apiResource('billingsystems','Setups\BillingSystemController',['only'=>['index','show','store','update']]);
        Route::apiResource('paymentstyles','Setups\PaymentStyleController',['only'=>['index','show','store','update']]);
        Route::apiResource('sponsorshiptypes','Setups\SponsorshipTypeController',['only'=>['index','show','store','update']]);
        Route::apiResource('paymentchannels','Setups\PaymentChannelController',['only'=>['index','show','store','update']]);

        Route::get('sponsorshiptypes/{sponsorshiptype}/fundingtypes','Setups\FundingTypeController@showBySponsorshipType')->name('sponsorshiptype.fundingtypes.show');
        Route::apiResource('fundingtypes','Setups\FundingTypeController',['only'=>['index','show','store','update']]);
        Route::apiResource('companies','Setups\CompanyController',['only'=>['index','show','store','update']]);
        Route::apiResource('specialties','Setups\SpecialtyController',['only'=>['index','show','store','update']]);

        Route::get('hospitalservices/{hospitalservice}/servicecategories','Setups\ServiceCategoryController@showByHospitalService')->name('hospitalservice.servicecategories.show');
        Route::apiResource('servicecategories','Setups\ServiceCategoryController',['only'=>['index','show','store','update']]);
        Route::get('servicecategories/{servicecategory}/servicesubcategories','Setups\ServiceSubCategoryController@showByServiceCategory')->name('servicecategory.servicesubcategories.show');
        Route::apiResource('servicesubcategories','Setups\ServiceSubCategoryController',['only'=>['index','show','store','update']]);

    });
    Route::group(['prefix' => 'utils'], function () {
        //FileResolver
       Route::get('file/{subdirectory?}/{path}','Utils\FileResolverController@index')->name('file.url');
    });
  });
});
