<?php

use Illuminate\Support\Facades\Route;

Route::apiResource('countries', 'Setups\CountryController', [
    'only' => ['index', 'show'],
    'module' => NULL,
    'components' => NULL
]);

Route::get('districts/{district}/towns', [
    'uses' => 'Setups\TownController@showByDistrict',
    'as' => 'district.towns.view'

]);
Route::apiResource('towns', 'Setups\TownController', [
    //'only'=>['index','show','store','update','delete']
    //'module' => 'config.record',
    //'component' => 'config.record.town'
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
    'module' => 'config.other',
    'component' => 'config.other.accreditation'
]);
Route::get('hospital', [
    'uses' => 'Setups\HospitalController@show',
    'as' => 'facility.view',
    //'module' => 'facility',
    //'component' => 'facility.detail'
]);
Route::post('hospital', [
    'uses' => 'Setups\HospitalController@store',
    'as' => 'facility.store',
    'module' => 'facility',
    'component' => 'facility.detail'
]);

Route::match(['PUT', 'PATCH'], 'hospital', [
    'uses' => 'Setups\HospitalController@update',
    'as' => 'facility.update',
    'module' => 'facility',
    'component' => 'facility.detail'
]);
Route::get('nhisaccreditation', [
    'uses' => 'Setups\NhisAccreditationSettingController@show',
    'as' => 'nhisaccreditation.view',
    'module' => 'facility',
    'component' => 'facility.detail.'
]);
Route::post('nhisaccreditation', [
    'uses' => 'Setups\NhisAccreditationSettingController@store',
    'as' => 'nhisaccreditation.store',
    'module' => 'facility',
    'component' => 'facility.nhis.accreditation'
]);

Route::match(['PUT', 'PATCH'], 'nhisaccreditation', [
    'uses' => 'Setups\NhisAccreditationSettingController@update',
    'as' => 'nhisaccreditation.update',
    'module' => 'facility',
    'component' => 'facility.nhis.accreditation'
]);

Route::apiResource('religions', 'Setups\ReligionController', [
    //'only'=>['index','show','store','update','delete'],
    //'module' => ['records-mgt', 'sys-mgt'],
    //'component' => 'setup.free.religions'
]);

Route::apiResource('relationships', 'Setups\RelationshipController', [
    //'only'=>['index','show','store','update','delete'],
    //'module' => ['records-mgt', 'sys-mgt'],
    //'component' => 'setup.free.relationships'
]);

Route::get('gender/{gender}/titles', [
    'uses' => 'Setups\TitleController@showByGender',
    'as' => 'gender.titles.view',
    //'module' => ['records-mgt', 'sys-mgt'],
    //'component' => 'setup.free.titles'
]);

Route::apiResource('titles', 'Setups\TitleController', [
    //'only'=>['index','show','store','update','delete'],
    //'module' => ['records-mgt', 'sys-mgt'],
    //'component' => 'setup.free.titles'
]);
Route::apiResource('departments', 'Setups\DepartmentController', [
    //'only'=>['index','show','store','update','delete'],
    'module' => 'config.other',
    'component' => 'config.other.department'
]);
Route::apiResource('agegroups', 'Setups\AgeGroupController', [
    //'only'=>['index','show','store','update','delete'],
    'module' => 'config.other',
    'component' => 'config.other.age.group'
]);
Route::apiResource('educationallevels', 'Setups\EducationalLevelController', [
    //'only'=>['index','show','store','update','delete'],
    'module' => 'config.record',
    'component' => 'config.record.education'
]);
Route::apiResource('idtypes', 'Setups\IDTypeController', [
    //'only'=>['index','show','store','update','delete'],
    'module' => 'config.record',
    'component' => 'config.record.id.type'
]);
Route::apiResource('banks', 'Setups\BankController', [
    //'only'=>['index','show','store','update'],
    'module' => 'config.other',
    'component' => 'config.other.bank'
]);

Route::get('banks/{bank}/branches', [
    'uses' => 'Setups\BankBranchController@showByBank',
    'as' => 'bank.branches.view',
    'module' => 'config.other',
    'component' => 'config.other.bank.branch'
]);
Route::apiResource('bankbranches', 'Setups\BankBranchController', [
    //'only'=>['index','show','store','update'],
    'module' => 'config.other',
    'component' => 'config.other.bank.branch'
]);
Route::apiResource('languages', 'Setups\LanguageController', [
    //'only'=>['index','show','store','update'],
    //'module' => ['records-mgt', 'sys-mgt'],
    //'component' => 'setup.free.languages'
]);
Route::apiResource('staffcategories', 'Setups\StaffCategoryController', [
    //'only'=>['index','show','store','update'],
    'module' => 'config.other',
    'component' => 'config.other.staff.category'
]);
Route::get('staffcategories/{staffcategory}/professions', [
    'uses' => 'Setups\ProfessionController@showByCategory',
    'as' => 'staffcategory.professions.view',
    'module' => 'config.other',
    'component' => 'config.other.profession'
]);
Route::apiResource('professions', 'Setups\ProfessionController', [
    //'only'=>['index','show','store','update','delete'],
    'module' => 'config.other',
    'component' => 'config.other.profession'
]);
Route::apiResource('stafftypes', 'Setups\StaffTypeController', [
    //'only'=>['index','show','store','update','delete'],
    'module' => 'config.other',
    'component' => 'config.other.staff.types'
]);

Route::apiResource('hospitalservices', 'Setups\HospitalServiceController', [
    //'only'=>['index','show','store','update'],
    'module' => 'config.account',
    'component' => 'config.account.hospital.service'
]);
Route::apiResource('billingcycles', 'Setups\BillingCycleController', [
    //'only'=>['index','show','store','update'],
    'module' => 'facility.funding',
    'component' => 'facility.funding.billing.cycle'
]);
Route::apiResource('billingsystems', 'Setups\BillingSystemController', [
    //'only'=>['index','show','store','update'],
    'module' => 'facility.funding',
    'component' => 'facility.funding.billing.system'
]);
Route::apiResource('paymentstyles', 'Setups\PaymentStyleController', [
    //'only'=>['index','show','store','update'],
    'module' => 'facility.funding',
    'component' => 'facility.funding.style'
]);
Route::apiResource('sponsorshiptypes', 'Setups\SponsorshipTypeController', [
    //'only'=>['index','show','store','update'],
    'module' => 'config.other',
    'component' => 'config.other.sponsorship.type'
]);
Route::apiResource('sponsorpolicies', 'Setups\SponsorshipPolicyController', [
    //'only'=>['index','show','store','update'],
    'module' => 'config.account',
    'component' => 'config.account.sponsor.policy'
]);

Route::apiResource('paymentchannels', 'Setups\PaymentChannelController', [
    //'only'=>['index','show','store','update'],
    'module' => 'facility.funding',
    'component' => 'facility.funding.channel'
]);

Route::get('sponsorshiptypes/{sponsorshiptype}/fundingtypes', [
    'uses' => 'Setups\FundingTypeController@showBySponsorshipType',
    'as' => 'sponsorshiptype.fundingtypes.view',
    'module' => 'facility.funding',
    'component' => 'facility.funding.type'
]);
Route::apiResource('fundingtypes', 'Setups\FundingTypeController', [
    //'only'=>['index','show','store','update'],
    'module' => 'facility.funding',
    'component' => 'facility.funding.type'
]);

Route::apiResource('billingsponsors', 'Setups\BillingSponsorController', [
    //'only'=>['index','show','store','update'],
    'module' => 'config.other',
    'component' => 'config.other.medical.sponsor'
]);

Route::apiResource('companies', 'Setups\CompanyController', [
    //'only'=>['index','show','store','update'],
    'module' => 'config.other',
    'component' => 'config.other.company'
]);
Route::apiResource('specialties', 'Setups\SpecialtyController', [
    //'only'=>['index','show','store','update'],
    'module' => 'config.other',
    'component' => 'config.other.specialty'
]);

Route::get('hospitalservices/{hospitalservice}/servicecategories', [
    'uses' => 'Setups\ServiceCategoryController@showByHospitalService',
    'as' => 'hospitalservice.servicecategories.view',
    'module' => 'config.account',
    'component' => 'config.account.hospital.service'
]);
Route::apiResource('servicecategories', 'Setups\ServiceCategoryController', [
    //'only'=>['index','show','store','update'],
    'module' => 'config.account',
    'component' => 'config.account.service.category'
]);
Route::get('servicecategories/{servicecategory}/servicesubcategories', [
    'uses' => 'Setups\ServiceSubCategoryController@showByServiceCategory',
    'as' => 'servicecategory.servicesubcategories.view',
    'module' => 'config.account',
    'component' => 'config.account.service.sub.category'
]);
Route::apiResource('servicesubcategories', 'Setups\ServiceSubCategoryController', [
    //'only'=>['index','show','store','update'],
    'module' => 'config.account',
    'component' => 'config.account.service.sub.category'
]);
Route::post('clinicservices/multiple', [
    'uses' => 'Setups\ClinicServiceController@storeMultiple',
    'as' => 'clinicsservices.multiple.store',
    'module' => 'config.other',
    'component' => 'config.other.clinic.service'
]);
Route::apiResource('clinictypes', 'Setups\ClinicTypeController', [
    'module' => 'config.other',
    'component' => 'config.other.clinic.type'
]);
Route::apiResource('clinics', 'Setups\ClinicController', [
    //'only'=>['index','show','store','update'],
    'module' => 'config.other',
    'component' => 'config.other.clinic'
]);

Route::apiResource('clinicservices', 'Setups\ClinicServiceController', [
    //'only'=>['index','show','store','update'],
    'module' => 'config.other',
    'component' => 'config.other.clinic.service'
]);

Route::apiResource('measurements', 'Setups\MeasurementController', [
    //'only'=>['index','show','store','update'],
    'module' => 'config.other',
    'component' => 'config.other.clinic.service'
]);
//====Consulting Room setup Routes====
Route::apiResource('consultationquestions', 'Setups\ConsultationQuestionsController', [
    'module' => 'config.clinic',
    'component' => 'config.clinic.questionaire'
]);
Route::apiResource('consultationquestionoptions', 'Setups\ConsultationQuestionOptionsController', [
    'module' => 'config.clinic',
    'component' => 'config.clinic.questionaire'
]);
Route::post('clinicservices/{service_id}/consultationquestions', 'Setups\ClinicServiceController@saveQuestions');
Route::put('clinicservices/{service_id}/consultationquestions', 'Setups\ClinicServiceController@saveQuestions');
Route::get('clinicservices/{service_id}/consultationquestions', 'Setups\ClinicServiceController@questionsList');


Route::apiResource('consultationcomponents', 'Setups\ConsultationComponentsController', [
    'module' => 'facility',
    'component' => 'facility.consultation.components'
]);
Route::post('clinicservices/{service_id}/consultationcomponents', 'Setups\ClinicServiceController@saveComponents');
Route::put('clinicservices/{service_id}/consultationcomponents', 'Setups\ClinicServiceController@saveComponents');
Route::get('clinicservices/{service_id}/consultationcomponents', 'Setups\ClinicServiceController@componentsList');

Route::apiResource('illnesstypes', 'Setups\IllnessTypeController', [
    //'only'=>['index','show','store','update'],
    'module' => 'config.clinic',
    'component' => 'config.clinic.illness.type'
]);
Route::apiResource('dischargereasons', 'Setups\DischargeReasonController', [
    //'only'=>['index','show','store','update'],
    'module' => 'config.clinic',
    'component' => 'config.clinic.discharge.reason'
]);
Route::apiResource('complainttypes', 'Setups\ComplaintTypeController', [
    //'only'=>['index','show','store','update'],
    'module' => 'config.clinic',
    'component' => 'config.clinic.conplaint.type'
]);
Route::apiResource('complaints', 'Setups\ComplaintController', [
    //'only'=>['index','show','store','update'],
    'module' => 'config.clinic',
    'component' => 'config.clinic.conplaint'
]);
Route::apiResource('allergyhistorycategories', 'Setups\AllergyHistoryCategoryController', [
    //'only'=>['index','show','store','update'],
    'module' => 'config.clinic',
    'component' => 'config.clinic.allergy.history.category'
]);
Route::apiResource('allergyhistories', 'Setups\AllergyHistoryController', [
    //'only'=>['index','show','store','update'],
    'module' =>'config.clinic',
    'component' => 'config.clinic.allergy.history'
]);
Route::apiResource('familyhistorycategories', 'Setups\FamilyHistoryCategoryController', [
    //'only'=>['index','show','store','update'],
    'module' => 'config.clinic',
    'component' => 'config.clinic.family.history.category'
]);
Route::apiResource('familyhistories', 'Setups\FamilyHistoryController', [
    //'only'=>['index','show','store','update'],
    'module' => 'config.clinic',
    'component' => 'config.clinic.family.history'
]);
Route::apiResource('medicalhistorycategories', 'Setups\MedicalHistoryCategoryController', [
    //'only'=>['index','show','store','update'],
    'module' => 'config.clinic',
    'component' => 'config.clinic.medical.history.category'
]);
Route::apiResource('medicalhistories', 'Setups\MedicalHistoryController', [
    //'only'=>['index','show','store','update'],
    'module' => 'config.clinic',
    'component' => 'config.clinic.medical.history'
]);
Route::apiResource('medicinehistorycategories', 'Setups\MedicineHistoryCategoryController', [
    //'only'=>['index','show','store','update'],
    'module' => 'config.clinic',
    'component' => 'config.clinic.medicine.history.category'
]);
Route::apiResource('medicinehistories', 'Setups\MedicineHistoryController', [
    //'only'=>['index','show','store','update'],
    'module' => 'config.clinic',
    'component' => 'config.clinic.medicine.history'
]);
Route::apiResource('socialhistorycategories', 'Setups\SocialHistoryCategoryController', [
    //'only'=>['index','show','store','update'],
    'module' => 'config.clinic',
    'component' => 'config.clinic.social.history.category'
]);
Route::apiResource('socialhistories', 'Setups\SocialHistoryController', [
    //'only'=>['index','show','store','update'],
    'module' => 'config.clinic',
    'component' => 'config.clinic.social.history'
]);
Route::apiResource('surgicalhistorycategories', 'Setups\SurgicalHistoryCategoryController', [
    //'only'=>['index','show','store','update'],
    'module' => 'config.clinic',
    'component' => 'config.clinic.surgical.history.category'
]);
Route::apiResource('surgicalhistories', 'Setups\SurgicalHistoryController', [
    //'only'=>['index','show','store','update'],
    'module' => 'config.clinic',
    'component' => 'config.clinic.surgical.history'
]);
Route::apiResource('physicalexaminationcategories', 'Setups\PhysicalExaminationCategoryController', [
    //'only'=>['index','show','store','update'],
    'module' => 'config.clinic',
    'component' => 'config.clinic.physical.examination.category'
]);
Route::apiResource('physicalexaminationtypes', 'Setups\PhysicalExaminationTypeController', [
    //'only'=>['index','show','store','update'],
    'module' => 'config.clinic',
    'component' => 'config.clinic.physical.examination.type'
]);
Route::apiResource('icd10groupings', 'Setups\Icd10GroupingController', [
    //'only'=>['index','show','store','update'],
    'module' => 'config.clinic',
    'component' => 'config.clinic.icd.10.grouping'
]);
Route::apiResource('icd10categories', 'Setups\Icd10CategoryController', [
    //'only'=>['index','show','store','update'],
    'module' => 'config.clinic',
    'component' => 'config.clinic.icd.10.category'
]);
Route::apiResource('mohghsgroupings', 'Setups\MohGhsGroupingController', [
    //'only'=>['index','show','store','update'],
    'module' => 'config.clinic',
    'component' => 'config.clinic.moh.ghs.groupings'
]);
Route::get('diseases/page', 'Setups\DiseaseController@page', [
    //'only'=>['index','show','store','update'],
    'module' => 'config.clinic',
    'component' => 'config.clinic.disease'
]);
Route::apiResource('diseases', 'Setups\DiseaseController', [
    //'only'=>['index','show','store','update'],
    'module' => 'config.clinic',
    'component' => 'config.clinic.disease'
]);
//====End of Consulting room setup Routes====

Route::apiResource('agecategories', 'Setups\AgeCategoryController', [
    //'only'=>['index','show','store','update','delete'],
    'module' => 'config.other',
    'component' => 'config.other.age.category'
]);

Route::apiResource('ageclassifications', 'Setups\AgeClassificationController', [
    //'only'=>['index','show','store','update','delete'],
    'module' => 'config.other',
    'component' => 'config.other.age.classification'
]);

Route::apiResource('nhisproviderlevels', 'Setups\NhisProviderLevelController',[
    'module' => 'config.einsu',
    'component' => 'config.einsu.nhis.provider.level'
]);
Route::apiResource('majordiagnosticcategories', 'Setups\MajorDiagnosticCategoryController',[
    'module' => 'config.einsu',
    'component' => 'config.einsu.nhis.mdc'
]);
Route::get('nhisgdrgservicetariffs/page', 'Setups\NhisGdrgServiceTariffController@page',[
    'module' => 'config.einsu',
    'component' => 'config.einsu.nhis.tariff'
]);
Route::post('nhisgdrgservicetariffs/map', 'Setups\NhisGdrgServiceTariffController@map',[
    'module' => 'config.einsu',
    'component' => 'config.einsu.nhis.mapping'
]);
Route::apiResource('nhisgdrgservicetariffs', 'Setups\NhisGdrgServiceTariffController',[
    'module' => 'config.einsu',
    'component' => 'config.einsu.nhis.tariff'
]);
Route::apiResource('nhisgdrgservicecoverage', 'Setups\NhisGdrgServiceCoverageController',[
    'module' => 'config.einsu',
    'component' => 'config.einsu.nhis.tariff'
]);

//Service Rules
Route::apiResource('servicerules', 'Setups\ServiceRuleController',[
    'module'=>'facility',
    'component'=>'facility.free.servicerules'
]);
