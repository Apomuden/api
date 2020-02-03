<?php
use Illuminate\Support\Facades\Route;

Route::apiResource('countries','Setups\CountryController',[
    'only'=>['index','show'],
    'module'=>NULL,
    'components'=>NULL
]);

Route::get('districts/{district}/towns',[
    'uses'=>'Setups\TownController@showByDistrict',
    'as'=>'district.towns.view',
    'module'=>['records-mgt','sys-mgt'],
    'component'=>'setup.free.towns'
]);
Route::apiResource('towns','Setups\TownController',[
    //'only'=>['index','show','store','update','delete']
    'module'=>['records-mgt','sys-mgt'],
    'component'=>'setup.free.towns'
]);

Route::get('countries/{country}/regions',[
    'uses'=>'Setups\RegionController@showByCountry',
    'as'=>'country.regions.view',
    'module'=>NULL,
    'component'=>NULL
]);
Route::apiResource('regions','Setups\RegionController',[
    'only'=>['index','show'],
    'module'=>NULL,
    'component'=>NULL
]);
Route::get('regions/{region}/districts',[
    'uses'=>'Setups\DistrictController@showByRegion',
    'as'=>'region.districts.view',
    'module'=>NULL,
    'component'=>NULL
]);
Route::apiResource('districts','Setups\DistrictController',['only'=>['index','show','store','update','delete']]);
Route::apiResource('accreditations','Setups\AccreditationController',[
    //'only'=>['index','show','store','update','delete'],
    'module'=>'sys-mgt',
    'component'=>'setup.accreditations'
]);
Route::get('hospital',[
    'uses'=>'Setups\HospitalController@show',
    'as'=>'facility.view',
    'module'=>'sys-mgt',
    'component'=>'setup.facility'
]);
Route::post('hospital',[
    'uses'=>'Setups\HospitalController@store',
    'as'=>'facility.store',
    'module'=>'sys-mgt',
    'component'=>'setup.facility'
]);

Route::match(['PUT', 'PATCH'], 'hospital',[
    'uses'=>'Setups\HospitalController@update',
    'as'=>'facility.update',
    'module'=>'sys-mgt',
    'component'=>'setup.facility'
]);

Route::apiResource('religions','Setups\ReligionController',[
    //'only'=>['index','show','store','update','delete'],
    'module'=>['records-mgt','sys-mgt'],
    'component'=>'setup.free.religions'
]);

Route::apiResource('relationships','Setups\RelationshipController',[
    //'only'=>['index','show','store','update','delete'],
    'module'=>['records-mgt','sys-mgt'],
    'component'=>'setup.free.relationships'
]);

Route::get('gender/{gender}/titles',[
    'uses'=>'Setups\TitleController@showByGender',
    'as'=>'gender.titles.view',
    'module'=>['records-mgt','sys-mgt'],
    'component'=>'setup.free.titles'
]);

Route::apiResource('titles','Setups\TitleController',[
    //'only'=>['index','show','store','update','delete'],
    'module'=>['records-mgt','sys-mgt'],
    'component'=>'setup.free.titles'
]);
Route::apiResource('departments','Setups\DepartmentController',[
    //'only'=>['index','show','store','update','delete'],
    'module'=>['records-mgt','sys-mgt'],
    'component'=>'setup.departments'
]);
Route::apiResource('agegroups','Setups\AgeGroupController',[
    //'only'=>['index','show','store','update','delete'],
    'module'=>['records-mgt','sys-mgt'],
    'component'=>'setup.agegroups'
]);
Route::apiResource('educationallevels','Setups\EducationalLevelController',[
    //'only'=>['index','show','store','update','delete'],
    'module'=>['records-mgt','sys-mgt'],
    'component'=>'setup.free.educationallevels'
]);
Route::apiResource('idtypes','Setups\IDTypeController',[
    //'only'=>['index','show','store','update','delete'],
    'module'=>['records-mgt','sys-mgt'],
    'component'=>'setup.free.idtypes'
]);
Route::apiResource('banks','Setups\BankController',[
    //'only'=>['index','show','store','update'],
    'module'=>['records-mgt','sys-mgt'],
    'component'=>'setup.free.banks'
]);

Route::get('banks/{bank}/branches',[
    'uses'=>'Setups\BankBranchController@showByBank',
    'as'=>'bank.branches.view',
    'module'=>['records-mgt','sys-mgt'],
    'component'=>'setup.free.banks'
]);
Route::apiResource('bankbranches','Setups\BankBranchController',[
    //'only'=>['index','show','store','update'],
    'module'=>['records-mgt','sys-mgt'],
    'component'=>'setup.free.bankbranches'
]);
Route::apiResource('languages','Setups\LanguageController',[
    //'only'=>['index','show','store','update'],
    'module'=>['records-mgt','sys-mgt'],
    'component'=>'setup.free.languages'
]);
Route::apiResource('staffcategories','Setups\StaffCategoryController',[
    //'only'=>['index','show','store','update'],
    'module'=>['records-mgt','sys-mgt'],
    'component'=>'setup.free.staffcategories'
]);
Route::get('staffcategories/{staffcategory}/professions',[
    'uses'=>'Setups\ProfessionController@showByCategory',
    'as'=>'staffcategory.professions.view',
    'module'=>['records-mgt','sys-mgt'],
    'component'=>'setup.free.professions'
]);
Route::apiResource('professions','Setups\ProfessionController',[
    //'only'=>['index','show','store','update','delete'],
    'module'=>['records-mgt','sys-mgt'],
    'component'=>'setup.free.professions'
]);
Route::apiResource('stafftypes','Setups\StaffTypeController',[
    //'only'=>['index','show','store','update','delete'],
    'module'=>['records-mgt','sys-mgt'],
    'component'=>'setup.stafftypes'
]);

Route::apiResource('hospitalservices','Setups\HospitalServiceController',[
    //'only'=>['index','show','store','update'],
    'module'=>['records-mgt','sys-mgt'],
    'component'=>'setup.hospitalservices'
]);
Route::apiResource('billingcycles','Setups\BillingCycleController',[
    //'only'=>['index','show','store','update'],
    'module'=>['records-mgt','sys-mgt'],
    'component'=>'setup.billingcycles'
]);
Route::apiResource('billingsystems','Setups\BillingSystemController',[
    //'only'=>['index','show','store','update'],
    'module'=>['records-mgt','sys-mgt'],
    'component'=>'setup.billingsystems'
]);
Route::apiResource('paymentstyles','Setups\PaymentStyleController',[
    //'only'=>['index','show','store','update'],
    'module'=>['records-mgt','sys-mgt'],
    'component'=>'setup.paymentstyles'
]);
Route::apiResource('sponsorshiptypes','Setups\SponsorshipTypeController',[
    //'only'=>['index','show','store','update'],
    'module'=>['records-mgt','sys-mgt'],
    'component'=>'setup.sponsorshiptypes'
]);
Route::apiResource('sponsorpolicies', 'Setups\SponsorshipPolicyController',[
    //'only'=>['index','show','store','update'],
    'module'=>['records-mgt','sys-mgt'],
    'component'=>'setup.sponsorshiptypes'
]);

Route::apiResource('paymentchannels','Setups\PaymentChannelController',[
    //'only'=>['index','show','store','update'],
    'module'=>['records-mgt','sys-mgt'],
    'component'=>'setup.paymentchannels'
]);

Route::get('sponsorshiptypes/{sponsorshiptype}/fundingtypes',[
    'uses'=>'Setups\FundingTypeController@showBySponsorshipType',
    'as'=>'sponsorshiptype.fundingtypes.view',
    'module'=>['records-mgt','sys-mgt'],
    'component'=>'setup.fundingtypes'
]);
Route::apiResource('fundingtypes','Setups\FundingTypeController',[
    //'only'=>['index','show','store','update'],
    'module'=>['records-mgt','sys-mgt'],
    'component'=>'setup.fundingtypes'
]);

Route::apiResource('billingsponsors','Setups\BillingSponsorController',[
    //'only'=>['index','show','store','update'],
    'module'=>['records-mgt','sys-mgt'],
    'component'=>'setup.billingsponsors'
]);


Route::apiResource('companies','Setups\CompanyController',[
    //'only'=>['index','show','store','update'],
    'module'=>['records-mgt','sys-mgt'],
    'component'=>'setup.companies'
]);
Route::apiResource('specialties','Setups\SpecialtyController',[
    //'only'=>['index','show','store','update'],
    'module'=>['records-mgt','sys-mgt'],
    'component'=>'setup.specialties'
]);

Route::get('hospitalservices/{hospitalservice}/servicecategories',[
    'uses'=>'Setups\ServiceCategoryController@showByHospitalService',
    'as'=>'hospitalservice.servicecategories.view',
    'module'=>['records-mgt','sys-mgt'],
    'component'=>'setup.servicecategories'
]);
Route::apiResource('servicecategories','Setups\ServiceCategoryController',[
    //'only'=>['index','show','store','update'],
    'module'=>['records-mgt','sys-mgt'],
    'component'=>'setup.servicecategories'
]);
Route::get('servicecategories/{servicecategory}/servicesubcategories',[
    'uses'=>'Setups\ServiceSubCategoryController@showByServiceCategory',
    'as'=>'servicecategory.servicesubcategories.view',
    'module'=>['records-mgt','sys-mgt'],
    'component'=>'setup.servicesubcategories'
]);
Route::apiResource('servicesubcategories','Setups\ServiceSubCategoryController',[
    //'only'=>['index','show','store','update'],
    'module'=>['records-mgt','sys-mgt'],
    'component'=>'setup.servicesubcategories'
]);

Route::post('clinics/withconsultationservices',[
    'uses'=>'Setups\ClinicController@storeWithConsultServices',
    'as'=> 'clinics.withconsultationservices.store',
    'module' => ['records-mgt', 'sys-mgt'],
    'component' => 'setup.free.clinics'
]);
Route::apiResource('clinics','Setups\ClinicController',[
    //'only'=>['index','show','store','update'],
    'module'=>['records-mgt','sys-mgt'],
    'component'=> 'setup.free.clinics'
]);

Route::apiResource('consultationservices','Setups\ClinicConsultServiceController',[
    //'only'=>['index','show','store','update'],
    'module'=>['records-mgt','sys-mgt'],
    'component'=> 'setup.free.clinics'
]);
