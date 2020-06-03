<?php

use Illuminate\Support\Facades\Route;

Route::apiResource('countries', 'Setups\CountryController', [
    'only' => ['index', 'show'],
    'module' => NULL,
    'components' => NULL
]);

Route::get('districts/{district}/towns', [
    'uses' => 'Setups\TownController@showByDistrict',
    'as' => 'district.towns.view',
    'module' => ['records-mgt', 'sys-mgt'],
    'component' => 'setup.free.towns'
]);
Route::apiResource('towns', 'Setups\TownController', [
    //'only'=>['index','show','store','update','delete']
    'module' => ['records-mgt', 'sys-mgt'],
    'component' => 'setup.free.towns'
]);

Route::get('countries/{country}/regions', [
    'uses' => 'Setups\RegionController@showByCountry',
    'as' => 'country.regions.view',
    'module' => NULL,
    'component' => NULL
]);
Route::apiResource('regions', 'Setups\RegionController', [
    'only' => ['index', 'show'],
    'module' => NULL,
    'component' => NULL
]);
Route::get('regions/{region}/districts', [
    'uses' => 'Setups\DistrictController@showByRegion',
    'as' => 'region.districts.view',
    'module' => NULL,
    'component' => NULL
]);
Route::apiResource('districts', 'Setups\DistrictController');
Route::apiResource('accreditations', 'Setups\AccreditationController', [
    //'only'=>['index','show','store','update','delete'],
    'module' => 'sys-mgt',
    'component' => 'setup.accreditations'
]);
Route::get('hospital', [
    'uses' => 'Setups\HospitalController@show',
    'as' => 'facility.view',
    'module' => 'sys-mgt',
    'component' => 'setup.facility'
]);
Route::post('hospital', [
    'uses' => 'Setups\HospitalController@store',
    'as' => 'facility.store',
    'module' => 'sys-mgt',
    'component' => 'setup.facility'
]);

Route::match(['PUT', 'PATCH'], 'hospital', [
    'uses' => 'Setups\HospitalController@update',
    'as' => 'facility.update',
    'module' => 'sys-mgt',
    'component' => 'setup.facility'
]);
Route::get('nhisaccreditation', [
    'uses' => 'Setups\NhisAccreditationSettingController@show',
    'as' => 'nhisaccreditation.view',
    'module' => 'sys-mgt',
    'component' => 'setup.free.e-inus'
]);
Route::post('nhisaccreditation', [
    'uses' => 'Setups\NhisAccreditationSettingController@store',
    'as' => 'nhisaccreditation.store',
    'module' => 'sys-mgt',
    'component' => 'setup.free.e-inus'
]);

Route::match(['PUT', 'PATCH'], 'nhisaccreditation', [
    'uses' => 'Setups\NhisAccreditationSettingController@update',
    'as' => 'nhisaccreditation.update',
    'module' => 'sys-mgt',
    'component' => 'setup.free.e-inus'
]);

Route::apiResource('religions', 'Setups\ReligionController', [
    //'only'=>['index','show','store','update','delete'],
    'module' => ['records-mgt', 'sys-mgt'],
    'component' => 'setup.free.religions'
]);

Route::apiResource('relationships', 'Setups\RelationshipController', [
    //'only'=>['index','show','store','update','delete'],
    'module' => ['records-mgt', 'sys-mgt'],
    'component' => 'setup.free.relationships'
]);

Route::get('gender/{gender}/titles', [
    'uses' => 'Setups\TitleController@showByGender',
    'as' => 'gender.titles.view',
    'module' => ['records-mgt', 'sys-mgt'],
    'component' => 'setup.free.titles'
]);

Route::apiResource('titles', 'Setups\TitleController', [
    //'only'=>['index','show','store','update','delete'],
    'module' => ['records-mgt', 'sys-mgt'],
    'component' => 'setup.free.titles'
]);
Route::apiResource('departments', 'Setups\DepartmentController', [
    //'only'=>['index','show','store','update','delete'],
    'module' => ['records-mgt', 'sys-mgt'],
    'component' => 'setup.departments'
]);
Route::apiResource('agegroups', 'Setups\AgeGroupController', [
    //'only'=>['index','show','store','update','delete'],
    'module' => ['records-mgt', 'sys-mgt'],
    'component' => 'setup.agegroups'
]);
Route::apiResource('educationallevels', 'Setups\EducationalLevelController', [
    //'only'=>['index','show','store','update','delete'],
    'module' => ['records-mgt', 'sys-mgt'],
    'component' => 'setup.free.educationallevels'
]);
Route::apiResource('idtypes', 'Setups\IDTypeController', [
    //'only'=>['index','show','store','update','delete'],
    'module' => ['records-mgt', 'sys-mgt'],
    'component' => 'setup.free.idtypes'
]);
Route::apiResource('banks', 'Setups\BankController', [
    //'only'=>['index','show','store','update'],
    'module' => ['records-mgt', 'sys-mgt'],
    'component' => 'setup.free.banks'
]);

Route::get('banks/{bank}/branches', [
    'uses' => 'Setups\BankBranchController@showByBank',
    'as' => 'bank.branches.view',
    'module' => ['records-mgt', 'sys-mgt'],
    'component' => 'setup.free.banks'
]);
Route::apiResource('bankbranches', 'Setups\BankBranchController', [
    //'only'=>['index','show','store','update'],
    'module' => ['records-mgt', 'sys-mgt'],
    'component' => 'setup.free.bankbranches'
]);
Route::apiResource('languages', 'Setups\LanguageController', [
    //'only'=>['index','show','store','update'],
    'module' => ['records-mgt', 'sys-mgt'],
    'component' => 'setup.free.languages'
]);
Route::apiResource('staffcategories', 'Setups\StaffCategoryController', [
    //'only'=>['index','show','store','update'],
    'module' => ['records-mgt', 'sys-mgt'],
    'component' => 'setup.free.staffcategories'
]);
Route::get('staffcategories/{staffcategory}/professions', [
    'uses' => 'Setups\ProfessionController@showByCategory',
    'as' => 'staffcategory.professions.view',
    'module' => ['records-mgt', 'sys-mgt'],
    'component' => 'setup.free.professions'
]);
Route::apiResource('professions', 'Setups\ProfessionController', [
    //'only'=>['index','show','store','update','delete'],
    'module' => ['records-mgt', 'sys-mgt'],
    'component' => 'setup.free.professions'
]);
Route::apiResource('stafftypes', 'Setups\StaffTypeController', [
    //'only'=>['index','show','store','update','delete'],
    'module' => ['records-mgt', 'sys-mgt'],
    'component' => 'setup.stafftypes'
]);

Route::apiResource('hospitalservices', 'Setups\HospitalServiceController', [
    //'only'=>['index','show','store','update'],
    'module' => ['records-mgt', 'sys-mgt'],
    'component' => 'setup.hospitalservices'
]);
Route::apiResource('billingcycles', 'Setups\BillingCycleController', [
    //'only'=>['index','show','store','update'],
    'module' => ['records-mgt', 'sys-mgt'],
    'component' => 'setup.billingcycles'
]);
Route::apiResource('billingsystems', 'Setups\BillingSystemController', [
    //'only'=>['index','show','store','update'],
    'module' => ['records-mgt', 'sys-mgt'],
    'component' => 'setup.billingsystems'
]);
Route::apiResource('paymentstyles', 'Setups\PaymentStyleController', [
    //'only'=>['index','show','store','update'],
    'module' => ['records-mgt', 'sys-mgt'],
    'component' => 'setup.paymentstyles'
]);
Route::apiResource('sponsorshiptypes', 'Setups\SponsorshipTypeController', [
    //'only'=>['index','show','store','update'],
    'module' => ['records-mgt', 'sys-mgt'],
    'component' => 'setup.sponsorshiptypes'
]);
Route::apiResource('sponsorpolicies', 'Setups\SponsorshipPolicyController', [
    //'only'=>['index','show','store','update'],
    'module' => ['records-mgt', 'sys-mgt'],
    'component' => 'setup.sponsorshiptypes'
]);

Route::apiResource('paymentchannels', 'Setups\PaymentChannelController', [
    //'only'=>['index','show','store','update'],
    'module' => ['records-mgt', 'sys-mgt'],
    'component' => 'setup.paymentchannels'
]);

Route::get('sponsorshiptypes/{sponsorshiptype}/fundingtypes', [
    'uses' => 'Setups\FundingTypeController@showBySponsorshipType',
    'as' => 'sponsorshiptype.fundingtypes.view',
    'module' => ['records-mgt', 'sys-mgt'],
    'component' => 'setup.fundingtypes'
]);
Route::apiResource('fundingtypes', 'Setups\FundingTypeController', [
    //'only'=>['index','show','store','update'],
    'module' => ['records-mgt', 'sys-mgt'],
    'component' => 'setup.fundingtypes'
]);

Route::apiResource('billingsponsors', 'Setups\BillingSponsorController', [
    //'only'=>['index','show','store','update'],
    'module' => ['records-mgt', 'sys-mgt'],
    'component' => 'setup.billingsponsors'
]);


Route::apiResource('companies', 'Setups\CompanyController', [
    //'only'=>['index','show','store','update'],
    'module' => ['records-mgt', 'sys-mgt'],
    'component' => 'setup.companies'
]);
Route::apiResource('specialties', 'Setups\SpecialtyController', [
    //'only'=>['index','show','store','update'],
    'module' => ['records-mgt', 'sys-mgt'],
    'component' => 'setup.specialties'
]);

Route::get('hospitalservices/{hospitalservice}/servicecategories', [
    'uses' => 'Setups\ServiceCategoryController@showByHospitalService',
    'as' => 'hospitalservice.servicecategories.view',
    'module' => ['records-mgt', 'sys-mgt'],
    'component' => 'setup.servicecategories'
]);
Route::apiResource('servicecategories', 'Setups\ServiceCategoryController', [
    //'only'=>['index','show','store','update'],
    'module' => ['records-mgt', 'sys-mgt'],
    'component' => 'setup.servicecategories'
]);
Route::get('servicecategories/{servicecategory}/servicesubcategories', [
    'uses' => 'Setups\ServiceSubCategoryController@showByServiceCategory',
    'as' => 'servicecategory.servicesubcategories.view',
    'module' => ['records-mgt', 'sys-mgt'],
    'component' => 'setup.servicesubcategories'
]);
Route::apiResource('servicesubcategories', 'Setups\ServiceSubCategoryController', [
    //'only'=>['index','show','store','update'],
    'module' => ['records-mgt', 'sys-mgt'],
    'component' => 'setup.servicesubcategories'
]);
Route::post('clinicservices/multiple', [
    'uses' => 'Setups\ClinicServiceController@storeMultiple',
    'as' => 'clinicsservices.multiple.store',
    'module' => ['records-mgt', 'sys-mgt'],
    'component' => 'setup.free.clinics'
]);
Route::apiResource('clinictypes', 'Setups\ClinicTypeController', [
    'module' => ['records-mgt', 'sys-mgt'],
    'component' => 'setup.free.clinics'
]);
Route::apiResource('clinics', 'Setups\ClinicController', [
    //'only'=>['index','show','store','update'],
    'module' => ['records-mgt', 'sys-mgt'],
    'component' => 'setup.free.clinics'
]);

Route::apiResource('clinicservices', 'Setups\ClinicServiceController', [
    //'only'=>['index','show','store','update'],
    'module' => ['records-mgt', 'sys-mgt'],
    'component' => 'setup.free.clinics'
]);

Route::apiResource('measurements', 'Setups\MeasurementController', [
    //'only'=>['index','show','store','update'],
    'module' => ['records-mgt', 'sys-mgt'],
    'component' => 'setup.free.clinics'
]);
//====Consulting Room setup Routes====

Route::apiResource('consultationquestions', 'Setups\ConsultationQuestionsController', [
    'module' => ['records-mgt', 'sys-mgt'],
    'component' => 'setup.free.clinics'
]);

Route::apiResource('consultationquestionoptions', 'Setups\ConsultationQuestionOptionsController', [
    'module' => ['records-mgt', 'sys-mgt'],
    'component' => 'setup.free.clinics'
]);
Route::post('clinicservices/{service_id}/consultationquestions', 'Pricing\ServiceController@saveQuestions');
Route::put('clinicservices/{service_id}/consultationquestions', 'Pricing\ServiceController@saveQuestions');
Route::get('clinicservices/{service_id}/consultationquestions', 'Pricing\ServiceController@questionsList');
Route::delete('clinicservices/{service_id}/consultationquestions', 'Pricing\ServiceController@detachQuestions');


Route::apiResource('consultationcomponents', 'Setups\ConsultationComponentsController', [
    'module' => 'sys-mgt',
    'component' => 'setup.facility'
]);
Route::post('clinicservices/{service_id}/consultationcomponents', 'Pricing\ServiceController@saveComponents');
Route::put('clinicservices/{service_id}/consultationcomponents', 'Pricing\ServiceController@saveComponents');
Route::get('clinicservices/{service_id}/consultationcomponents', 'Pricing\ServiceController@componentsList');
Route::delete('clinicservices/{service_id}/consultationcomponents', 'Pricing\ServiceController@detachComponents');

Route::apiResource('illnesstypes', 'Setups\IllnessTypeController', [
    //'only'=>['index','show','store','update'],
    'module' => ['records-mgt', 'sys-mgt'],
    'component' => 'setup.free.clinics'
]);
Route::apiResource('dischargereasons', 'Setups\DischargeReasonController', [
    //'only'=>['index','show','store','update'],
    'module' => ['records-mgt', 'sys-mgt'],
    'component' => 'setup.free.clinics'
]);
Route::apiResource('complainttypes', 'Setups\ComplaintTypeController', [
    //'only'=>['index','show','store','update'],
    'module' => ['records-mgt', 'sys-mgt'],
    'component' => 'setup.free.clinics'
]);
Route::apiResource('complaints', 'Setups\ComplaintController', [
    //'only'=>['index','show','store','update'],
    'module' => ['records-mgt', 'sys-mgt'],
    'component' => 'setup.free.clinics'
]);
Route::apiResource('allergyhistorycategories', 'Setups\AllergyHistoryCategoryController', [
    //'only'=>['index','show','store','update'],
    'module' => ['records-mgt', 'sys-mgt'],
    'component' => 'setup.free.clinics'
]);
Route::apiResource('allergyhistories', 'Setups\AllergyHistoryController', [
    //'only'=>['index','show','store','update'],
    'module' => ['records-mgt', 'sys-mgt'],
    'component' => 'setup.free.clinics'
]);
Route::apiResource('familyhistorycategories', 'Setups\FamilyHistoryCategoryController', [
    //'only'=>['index','show','store','update'],
    'module' => ['records-mgt', 'sys-mgt'],
    'component' => 'setup.free.clinics'
]);
Route::apiResource('familyhistories', 'Setups\FamilyHistoryController', [
    //'only'=>['index','show','store','update'],
    'module' => ['records-mgt', 'sys-mgt'],
    'component' => 'setup.free.clinics'
]);
Route::apiResource('medicalhistorycategories', 'Setups\MedicalHistoryCategoryController', [
    //'only'=>['index','show','store','update'],
    'module' => ['records-mgt', 'sys-mgt'],
    'component' => 'setup.free.clinics'
]);
Route::apiResource('medicalhistories', 'Setups\MedicalHistoryController', [
    //'only'=>['index','show','store','update'],
    'module' => ['records-mgt', 'sys-mgt'],
    'component' => 'setup.free.clinics'
]);
Route::apiResource('medicinehistorycategories', 'Setups\MedicineHistoryCategoryController', [
    //'only'=>['index','show','store','update'],
    'module' => ['records-mgt', 'sys-mgt'],
    'component' => 'setup.free.clinics'
]);
Route::apiResource('medicinehistories', 'Setups\MedicineHistoryController', [
    //'only'=>['index','show','store','update'],
    'module' => ['records-mgt', 'sys-mgt'],
    'component' => 'setup.free.clinics'
]);
Route::apiResource('socialhistorycategories', 'Setups\SocialHistoryCategoryController', [
    //'only'=>['index','show','store','update'],
    'module' => ['records-mgt', 'sys-mgt'],
    'component' => 'setup.free.clinics'
]);
Route::apiResource('socialhistories', 'Setups\SocialHistoryController', [
    //'only'=>['index','show','store','update'],
    'module' => ['records-mgt', 'sys-mgt'],
    'component' => 'setup.free.clinics'
]);
Route::apiResource('surgicalhistorycategories', 'Setups\SurgicalHistoryCategoryController', [
    //'only'=>['index','show','store','update'],
    'module' => ['records-mgt', 'sys-mgt'],
    'component' => 'setup.free.clinics'
]);
Route::apiResource('surgicalhistories', 'Setups\SurgicalHistoryController', [
    //'only'=>['index','show','store','update'],
    'module' => ['records-mgt', 'sys-mgt'],
    'component' => 'setup.free.clinics'
]);
Route::apiResource('physicalexaminationcategories', 'Setups\PhysicalExaminationCategoryController', [
    //'only'=>['index','show','store','update'],
    'module' => ['records-mgt', 'sys-mgt'],
    'component' => 'setup.free.clinics'
]);
Route::apiResource('physicalexaminationtypes', 'Setups\PhysicalExaminationTypeController', [
    //'only'=>['index','show','store','update'],
    'module' => ['records-mgt', 'sys-mgt'],
    'component' => 'setup.free.clinics'
]);
Route::apiResource('icd10groupings', 'Setups\Icd10GroupingController', [
    //'only'=>['index','show','store','update'],
    'module' => ['records-mgt', 'sys-mgt'],
    'component' => 'setup.free.clinics'
]);
Route::apiResource('icd10categories', 'Setups\Icd10CategoryController', [
    //'only'=>['index','show','store','update'],
    'module' => ['records-mgt', 'sys-mgt'],
    'component' => 'setup.free.clinics'
]);
Route::apiResource('mohghsgroupings', 'Setups\MohGhsGroupingController', [
    //'only'=>['index','show','store','update'],
    'module' => ['records-mgt', 'sys-mgt'],
    'component' => 'setup.free.clinics'
]);
Route::apiResource('diseases', 'Setups\DiseaseController', [
    //'only'=>['index','show','store','update'],
    'module' => ['records-mgt', 'sys-mgt'],
    'component' => 'setup.free.clinics'
]);
//====End of Consulting room setup Routes====

Route::apiResource('agecategories', 'Setups\AgeCategoryController', [
    //'only'=>['index','show','store','update','delete'],
    'module' => ['records-mgt', 'sys-mgt'],
    'component' => 'setup.agegroups'
]);

Route::apiResource('ageclassifications', 'Setups\AgeClassificationController', [
    //'only'=>['index','show','store','update','delete'],
    'module' => ['records-mgt', 'sys-mgt'],
    'component' => 'setup.agegroups'
]);

Route::apiResource('nhisproviderlevels', 'Setups\NhisProviderLevelController',[
    'module' => ['records-mgt', 'sys-mgt'],
    'component' => 'setup.free.e-inus'
]);
Route::apiResource('majordiagnosticcategories', 'Setups\MajorDiagnosticCategoryController',[
    'module' => ['records-mgt', 'sys-mgt'],
    'component' => 'setup.free.e-inus'
]);
Route::apiResource('nhisgdrgservicetariff', 'Setups\NhisGdrgServiceTariffController',[
    'module' => ['records-mgt', 'sys-mgt'],
    'component' => 'setup.free.e-inus'
]);
Route::apiResource('nhisgdrgservicecoverage', 'Setups\NhisGdrgServiceCoverageController',[
    'module' => ['records-mgt', 'sys-mgt'],
    'component' => 'setup.free.e-inus'
]);
