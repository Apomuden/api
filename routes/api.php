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

//Main Dashboard
Route::group(['prefix' => 'dashboard'], function () {
     Route::get('staffcategories','Summaries\StaffCategoryController@index')->name('dashboard.staffcategories');
});
//Auth Routes
Route::group(['prefix' => 'auth'], function () {
    Route::post('login', 'Auth\AccessController@login')->name('auth.login');
    Route::post('/rescue','Auth\AccessController@sendRecoveryMail')->name('auth.recovery');

      //Authenticated Auth Routes
    Route::group(['middleware'=>['jwt.auth']], function () {
        Route::post('logout', 'Auth\AccessController@logout')->name('auth.logout');
        Route::get('/refresh', 'Auth\AccessController@refresh')->name('auth.refresh');

        Route::get('roles/{role}/permissions/hierarchy','Auth\PermissionController@showHierarchyByRole')->name('role.permissions.hierarchy.show');
        Route::get('roles/{role}/permissions','Auth\PermissionController@showByRole')->name('role.permissions.show');

        //Authorization routes
        Route::put('roles/{role}/attachmodules','Auth\AuthorizationController@attachModulesToRole')->name('role.attachmodules');
        Route::put('roles/{role}/detachmodules','Auth\AuthorizationController@detachModulesFromRole')->name('role.detachmodules');
        Route::put('roles/{role}/detachmodules/cascade','Auth\AuthorizationController@detachModulesFromRoleCascade')->name('role.detachmodules.cascade');

        Route::put('roles/{role}/attachpermissions','Auth\AuthorizationController@attachPermissionsToRole')->name('role.attachpermissions');
        Route::put('roles/{role}/detachpermissions','Auth\AuthorizationController@detachPermissionsFromRole')->name('role.detachpermissions');
        Route::put('roles/{role}/detachpermissions/cascade','Auth\AuthorizationController@detachPermissionsFromRoleCascade')->name('role.detachpermissions.cascade');

         //Authorization routes
         Route::put('roles/{role}/attachcomponents','Auth\AuthorizationController@attachComponentsToRole')->name('role.attachcomponents');
         Route::put('roles/{role}/detachcomponents','Auth\AuthorizationController@detachComponentsFromRole')->name('role.detachcomponents');
         Route::put('roles/{role}/detachcomponents/cascade','Auth\AuthorizationController@detachComponentsFromRoleCascade')->name('role.detachcomponents.cascade');



        Route::apiResource('roles','Auth\RoleController',['only'=>['index','show','store','update']]);

        Route::apiResource('modules','Auth\ModuleController',['only'=>['index','show']]);
        Route::get('components/{component}/permissions','Auth\PermissionController@showByComponent')->name('component.permissions.show');
        Route::apiResource('components','Auth\ComponentController',['only'=>['index','show']]);




        Route::get('modules/{module}/components','Auth\ComponentController@showByModule')->name('module.components.show');

        Route::apiResource('permissions','Auth\PermissionController',['only'=>['index','show','update']]);

        //Logged In User Routes
        Route::group(['prefix' => 'profile'], function () {
            Route::get('permissions/hierarchy','Profile\ProfileController@showPermissionHierarchy')->name('profile.permissions.hierarchy.show');
            Route::get('permissions','Profile\ProfileController@showPermissions')->name('profile.permissions.show');
            Route::get('permissions/paginated','Profile\ProfileController@showPermissionsPaginated')->name('profile.permissions.paginated.show');
            Route::match(['PUT', 'PATCH'],'update','Profile\ProfileController@update')->name('profile.update');
            Route::apiResource('remarks','Profile\UserRemarkController',['only'=>['index','show','store','update']]);
        });

         //Registrations Routes
        Route::apiResource('profiles', 'Profile\UserRegisterationController',['only'=>['index','show','store','update']]);


        //User By Id
        Route::group(['prefix' => 'profiles'], function () {
            Route::get('{profile}/profiledocuments','Profile\ProfileDocumentController@showByProfile')->name('profile.profiledocuments.show');
            Route::get('{profile}/profilenextofkins','Profile\ProfileNextOfKinController@showByProfile')->name('profile.profilenextofkins.show');

            //Authorization routes
            Route::put('{profile}/attachmodules','Auth\AuthorizationController@attachModulesToUser')->name('profile.attachmodules');
            Route::put('{profile}/detachmodules','Auth\AuthorizationController@detachModulesFromUser')->name('profile.detachmodules');
            Route::put('{profile}/attachpermissions','Auth\AuthorizationController@attachPermissionsToUser')->name('profile.attachpermissions');
            Route::put('{profile}/detachpermissions','Auth\AuthorizationController@detachPermissionsFromUser')->name('profile.detachpermissions');
            Route::put('{profile}/attachcomponents','Auth\AuthorizationController@attachComponentsToUser')->name('profile.attachcomponents');
            Route::put('{profile}/detachcomponents','Auth\AuthorizationController@detachComponentsFromUser')->name('profile.detachcomponents');

            //User Permissions
            Route::get('{profile}/permissions','Auth\PermissionController@showPermissions')->name('profiles.single.permissions.show');
            Route::get('{profile}/permissions/hierarchy','Auth\PermissionController@showPermissionHierarchy')->name('profiles.single.permissions.hierarchy.show');
            Route::get('{profile}/permissions/paginated','Auth\PermissionController@showPermissionsPaginated')->name('profiles.single.permissions.paginated.show');

        });
        Route::apiResource('profilenextofkins','Profile\ProfileNextOfKinController',['only'=>['index','show','store','update']]);
        Route::apiResource('profiledocuments','Profile\ProfileDocumentController',['only'=>['index','show','store','update']]);

        //Consultations Routes
        Route::match(['PUT', 'PATCH'], 'consultations/{consultation}','Consultation\ConsultationController@update')->name('consultation.update');
        Route::apiResource('consultations','Consultation\ConsultationController',['only'=>['index','show','store','update']]);

    });

});

  //Authenticated Routes
  Route::group(['middleware'=>['jwt.auth']],function () {
    //Pricing
    Route::group(['prefix' => 'pricing'], function () {
        //Route::get('serviceprices/search','Pricing\ServicePricingController@search')->name('serviceprices.search');
        Route::apiResource('serviceprices','Pricing\ServicePricingController',['only'=>['index','show','store','update']]);
    });

    //Registrations
    Route::group(['prefix' => 'registry'], function () {
        Route::get('patients/paginated','Registration\PatientController@paginated')->name('registration.paginated.show');
        Route::apiResource('patients','Registration\PatientController',['only'=>['index','show','store','update']]);
        Route::apiResource('folders','Registration\FolderController',['only'=>['index','show','store','update']]);
        Route::apiResource('patientnextofkins','Registration\PatientNextOfKinController',['only'=>['index','show','store','update']]);
    });


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

        Route::apiResource('billingsponsors','Setups\BillingSponsorController',['only'=>['index','show','store','update']]);


        //Company routes
        // Route::get('companies/search','Setups\CompanyController@search')->name('companies.search');
        Route::apiResource('companies','Setups\CompanyController',['only'=>['index','show','store','update']]);
        Route::apiResource('specialties','Setups\SpecialtyController',['only'=>['index','show','store','update']]);

        Route::get('hospitalservices/{hospitalservice}/servicecategories','Setups\ServiceCategoryController@showByHospitalService')->name('hospitalservice.servicecategories.show');
        Route::apiResource('servicecategories','Setups\ServiceCategoryController',['only'=>['index','show','store','update']]);
        Route::get('servicecategories/{servicecategory}/servicesubcategories','Setups\ServiceSubCategoryController@showByServiceCategory')->name('servicecategory.servicesubcategories.show');
        Route::apiResource('servicesubcategories','Setups\ServiceSubCategoryController',['only'=>['index','show','store','update']]);

        //Clinic Routes
        Route::match(['PUT', 'PATCH'], 'clinics/{clinic}','Clinic\ClinicController@update')->name('clinic.update');
        Route::apiResource('clinics','Clinic\ClinicController',['only'=>['index','show','store','update']]);

    });


  });
  Route::group(['prefix' => 'utils'], function () {
    //FileResolver
   Route::get('file/{subdirectory?}/{path}','Utils\FileResolverController@index')->name('file.url');
});
});
