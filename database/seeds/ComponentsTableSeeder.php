<?php

use App\Models\Component;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ComponentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::statement('truncate table components');
        $components = array(
            array('id' => '1', 'parent_tag' => NULL, 'name' => 'Patient Registration', 'tag' => 'patient-registry', 'status' => 'ACTIVE', 'created_at' => '2020-01-07 00:00:00', 'updated_at' => '2020-01-07 00:00:00', 'deleted_at' => NULL),
            array('id' => '2', 'parent_tag' => NULL, 'name' => 'Request Consultation', 'tag' => 'request-consultation', 'status' => 'ACTIVE', 'created_at' => '2020-01-07 00:00:00', 'updated_at' => '2020-01-07 00:00:00', 'deleted_at' => NULL),
            array('id' => '3', 'parent_tag' => NULL, 'name' => 'Appointment', 'tag' => 'appointment', 'status' => 'ACTIVE', 'created_at' => '2020-01-07 00:00:00', 'updated_at' => '2020-01-07 00:00:00', 'deleted_at' => NULL),
            array('id' => '5', 'parent_tag' => NULL, 'name' => 'Walk-In Registration', 'tag' => 'walkin-registry', 'status' => 'ACTIVE', 'created_at' => '2020-01-07 00:00:00', 'updated_at' => '2020-01-07 00:00:00', 'deleted_at' => NULL),
            array('id' => '6', 'parent_tag' => NULL, 'name' => 'User Registration', 'tag' => 'user-registry', 'status' => 'ACTIVE', 'created_at' => '2020-01-07 00:00:00', 'updated_at' => '2020-01-07 00:00:00', 'deleted_at' => NULL),
            array('id' => '7', 'parent_tag' => NULL, 'name' => 'Inpatient Listing', 'tag' => 'ipd-listing', 'status' => 'ACTIVE', 'created_at' => '2020-01-07 00:00:00', 'updated_at' => '2020-01-07 00:00:00', 'deleted_at' => NULL),
            array('id' => '8', 'parent_tag' => NULL, 'name' => 'General Vitals', 'tag' => 'vitals', 'status' => 'ACTIVE', 'created_at' => '2020-01-07 00:00:00', 'updated_at' => '2020-01-07 00:00:00', 'deleted_at' => NULL),
            array('id' => '9', 'parent_tag' => NULL, 'name' => 'Nursing Notes', 'tag' => 'nursing-notes', 'status' => 'ACTIVE', 'created_at' => '2020-01-07 00:00:00', 'updated_at' => '2020-01-07 00:00:00', 'deleted_at' => NULL),
            array('id' => '10', 'parent_tag' => NULL, 'name' => 'Referrals', 'tag' => 'referrals', 'status' => 'ACTIVE', 'created_at' => '2020-01-07 00:00:00', 'updated_at' => '2020-01-07 00:00:00', 'deleted_at' => NULL),
            array('id' => '11', 'parent_tag' => NULL, 'name' => 'Inpatient Medications', 'tag' => 'ipd-medications', 'status' => 'ACTIVE', 'created_at' => '2020-01-07 00:00:00', 'updated_at' => '2020-01-07 00:00:00', 'deleted_at' => NULL),
            array('id' => '12', 'parent_tag' => NULL, 'name' => 'Dressing', 'tag' => 'dressing', 'status' => 'ACTIVE', 'created_at' => '2020-01-07 00:00:00', 'updated_at' => '2020-01-07 00:00:00', 'deleted_at' => NULL),
            array('id' => '13', 'parent_tag' => NULL, 'name' => 'Admission', 'tag' => 'admission', 'status' => 'ACTIVE', 'created_at' => '2020-01-07 00:00:00', 'updated_at' => '2020-01-07 00:00:00', 'deleted_at' => NULL),
            array('id' => '14', 'parent_tag' => NULL, 'name' => 'Discharges', 'tag' => 'discharges', 'status' => 'ACTIVE', 'created_at' => '2020-01-07 00:00:00', 'updated_at' => '2020-01-07 00:00:00', 'deleted_at' => NULL),
            array('id' => '15', 'parent_tag' => NULL, 'name' => 'Ward Transfer', 'tag' => 'ward-transfer', 'status' => 'ACTIVE', 'created_at' => '2020-01-07 00:00:00', 'updated_at' => '2020-01-07 00:00:00', 'deleted_at' => NULL),
            array('id' => '16', 'parent_tag' => NULL, 'name' => 'Inpatient fuide Output', 'tag' => 'ipd-fuide-output', 'status' => 'ACTIVE', 'created_at' => '2020-01-07 00:00:00', 'updated_at' => '2020-01-07 00:00:00', 'deleted_at' => NULL),
            array('id' => '17', 'parent_tag' => NULL, 'name' => 'Prescription', 'tag' => 'prescription', 'status' => 'ACTIVE', 'created_at' => '2020-01-07 00:00:00', 'updated_at' => '2020-01-07 00:00:00', 'deleted_at' => NULL),
            array('id' => '20', 'parent_tag' => NULL, 'name' => 'Consultation', 'tag' => 'consultation', 'status' => 'ACTIVE', 'created_at' => '2020-01-07 00:00:00', 'updated_at' => '2020-01-07 00:00:00', 'deleted_at' => NULL),
            array('id' => '21', 'parent_tag' => NULL, 'name' => 'Sample Collection', 'tag' => 'sample-collection', 'status' => 'ACTIVE', 'created_at' => '2020-01-07 00:00:00', 'updated_at' => '2020-01-07 00:00:00', 'deleted_at' => NULL),
            array('id' => '22', 'parent_tag' => NULL, 'name' => 'Test Result', 'tag' => 'test-result', 'status' => 'ACTIVE', 'created_at' => '2020-01-07 00:00:00', 'updated_at' => '2020-01-07 00:00:00', 'deleted_at' => NULL),
            array('id' => '23', 'parent_tag' => NULL, 'name' => 'Test Approval', 'tag' => 'test-approval', 'status' => 'ACTIVE', 'created_at' => '2020-01-07 00:00:00', 'updated_at' => '2020-01-07 00:00:00', 'deleted_at' => NULL),
            array('id' => '24', 'parent_tag' => NULL, 'name' => 'Dispensing', 'tag' => 'dispensing', 'status' => 'ACTIVE', 'created_at' => '2020-01-07 00:00:00', 'updated_at' => '2020-01-07 00:00:00', 'deleted_at' => NULL),
            array('id' => '25', 'parent_tag' => NULL, 'name' => 'Intervention', 'tag' => 'intervention', 'status' => 'ACTIVE', 'created_at' => '2020-01-07 00:00:00', 'updated_at' => '2020-01-07 00:00:00', 'deleted_at' => NULL),
            array('id' => '26', 'parent_tag' => NULL, 'name' => 'Prescription Return', 'tag' => 'prescription-return', 'status' => 'ACTIVE', 'created_at' => '2020-01-07 00:00:00', 'updated_at' => '2020-01-07 00:00:00', 'deleted_at' => NULL),
            array('id' => '27', 'parent_tag' => NULL, 'name' => 'E-Receipt', 'tag' => 'receipt', 'status' => 'ACTIVE', 'created_at' => '2020-01-07 00:00:00', 'updated_at' => '2020-01-07 00:00:00', 'deleted_at' => NULL),
            array('id' => '28', 'parent_tag' => NULL, 'name' => 'Deposit', 'tag' => 'deposit', 'status' => 'ACTIVE', 'created_at' => '2020-01-07 00:00:00', 'updated_at' => '2020-01-07 00:00:00', 'deleted_at' => NULL),
            array('id' => '29', 'parent_tag' => NULL, 'name' => 'Refund', 'tag' => 'refund', 'status' => 'ACTIVE', 'created_at' => '2020-01-07 00:00:00', 'updated_at' => '2020-01-07 00:00:00', 'deleted_at' => NULL),
            array('id' => '30', 'parent_tag' => NULL, 'name' => 'Discount', 'tag' => 'discount', 'status' => 'ACTIVE', 'created_at' => '2020-01-07 00:00:00', 'updated_at' => '2020-01-07 00:00:00', 'deleted_at' => NULL),
            array('id' => '31', 'parent_tag' => NULL, 'name' => 'Abscond', 'tag' => 'abscond', 'status' => 'ACTIVE', 'created_at' => '2020-01-07 00:00:00', 'updated_at' => '2020-01-07 00:00:00', 'deleted_at' => NULL),
            array('id' => '32', 'parent_tag' => NULL, 'name' => 'Requisition', 'tag' => 'requisition', 'status' => 'ACTIVE', 'created_at' => '2020-01-07 00:00:00', 'updated_at' => '2020-01-07 00:00:00', 'deleted_at' => NULL),
            array('id' => '33', 'parent_tag' => NULL, 'name' => 'Requisition Approval', 'tag' => 'requisition-approval', 'status' => 'ACTIVE', 'created_at' => '2020-01-07 00:00:00', 'updated_at' => '2020-01-07 00:00:00', 'deleted_at' => NULL),
            array('id' => '34', 'parent_tag' => NULL, 'name' => 'Requisition Supply', 'tag' => 'requisition-supply', 'status' => 'ACTIVE', 'created_at' => '2020-01-07 00:00:00', 'updated_at' => '2020-01-07 00:00:00', 'deleted_at' => NULL),
            array('id' => '35', 'parent_tag' => NULL, 'name' => 'Requisition Receival', 'tag' => 'requisition-receival', 'status' => 'ACTIVE', 'created_at' => '2020-01-07 00:00:00', 'updated_at' => '2020-01-07 00:00:00', 'deleted_at' => NULL),
            array('id' => '36', 'parent_tag' => NULL, 'name' => 'Requisition Return', 'tag' => 'requisition-return', 'status' => 'ACTIVE', 'created_at' => '2020-01-07 00:00:00', 'updated_at' => '2020-01-07 00:00:00', 'deleted_at' => NULL),
            array('id' => '37', 'parent_tag' => NULL, 'name' => 'Requisition Return Acceptance', 'tag' => 'requisition-return-acceptance', 'status' => 'ACTIVE', 'created_at' => '2020-01-07 00:00:00', 'updated_at' => '2020-01-07 00:00:00', 'deleted_at' => NULL),
            array('id' => '38', 'parent_tag' => NULL, 'name' => 'Anaesthesia', 'tag' => 'anaesthesia', 'status' => 'ACTIVE', 'created_at' => '2020-01-07 00:00:00', 'updated_at' => '2020-01-07 00:00:00', 'deleted_at' => NULL),
            array('id' => '39', 'parent_tag' => NULL, 'name' => 'Recovery', 'tag' => 'recovery', 'status' => 'ACTIVE', 'created_at' => '2020-01-07 00:00:00', 'updated_at' => '2020-01-07 00:00:00', 'deleted_at' => NULL),
            array('id' => '40', 'parent_tag' => NULL, 'name' => 'Birth Registry', 'tag' => 'birth-registry', 'status' => 'ACTIVE', 'created_at' => '2020-01-07 00:00:00', 'updated_at' => '2020-01-07 00:00:00', 'deleted_at' => NULL),
            array('id' => '41', 'parent_tag' => NULL, 'name' => 'Death Registry', 'tag' => 'death-registry', 'status' => 'ACTIVE', 'created_at' => '2020-01-07 00:00:00', 'updated_at' => '2020-01-07 00:00:00', 'deleted_at' => NULL),
            array('id' => '42', 'parent_tag' => NULL, 'name' => 'Invoice', 'tag' => 'invoice', 'status' => 'ACTIVE', 'created_at' => '2020-01-07 00:00:00', 'updated_at' => '2020-01-07 00:00:00', 'deleted_at' => NULL),
            array('id' => '43', 'parent_tag' => NULL, 'name' => 'Award Letter', 'tag' => 'award-letter', 'status' => 'ACTIVE', 'created_at' => '2020-01-07 00:00:00', 'updated_at' => '2020-01-07 00:00:00', 'deleted_at' => NULL),
            array('id' => '44', 'parent_tag' => NULL, 'name' => 'Purchase Order', 'tag' => 'purchase-order', 'status' => 'ACTIVE', 'created_at' => '2020-01-07 00:00:00', 'updated_at' => '2020-01-07 00:00:00', 'deleted_at' => NULL),
            array('id' => '45', 'parent_tag' => NULL, 'name' => 'Orders Received', 'tag' => 'orders-received', 'status' => 'ACTIVE', 'created_at' => '2020-01-07 00:00:00', 'updated_at' => '2020-01-07 00:00:00', 'deleted_at' => NULL),
            array('id' => '46', 'parent_tag' => NULL, 'name' => 'Roles', 'tag' => 'roles', 'status' => 'ACTIVE', 'created_at' => '2020-01-07 00:00:00', 'updated_at' => '2020-01-07 00:00:00', 'deleted_at' => NULL),
            array('id' => '47', 'parent_tag' => NULL, 'name' => 'Modules', 'tag' => 'modules', 'status' => 'ACTIVE', 'created_at' => '2020-01-07 00:00:00', 'updated_at' => '2020-01-07 00:00:00', 'deleted_at' => NULL),
            array('id' => '49', 'parent_tag' => NULL, 'name' => 'Role Modules', 'tag' => 'role-modules', 'status' => 'ACTIVE', 'created_at' => '2020-01-07 00:00:00', 'updated_at' => '2020-01-07 00:00:00', 'deleted_at' => NULL),
            array('id' => '50', 'parent_tag' => NULL, 'name' => 'User Modules', 'tag' => 'user-modules', 'status' => 'ACTIVE', 'created_at' => '2020-01-07 00:00:00', 'updated_at' => '2020-01-07 00:00:00', 'deleted_at' => NULL),
            array('id' => '52', 'parent_tag' => NULL, 'name' => 'Role Components', 'tag' => 'role-components', 'status' => 'ACTIVE', 'created_at' => '2020-01-07 00:00:00', 'updated_at' => '2020-01-07 00:00:00', 'deleted_at' => NULL),
            array('id' => '53', 'parent_tag' => NULL, 'name' => 'User Components', 'tag' => 'user-components', 'status' => 'ACTIVE', 'created_at' => '2020-01-07 00:00:00', 'updated_at' => '2020-01-07 00:00:00', 'deleted_at' => NULL),
            array('id' => '54', 'parent_tag' => NULL, 'name' => 'User Remarks', 'tag' => 'user-remarks', 'status' => 'ACTIVE', 'created_at' => '2020-01-07 00:00:00', 'updated_at' => '2020-01-07 00:00:00', 'deleted_at' => NULL),
            array('id' => '55', 'parent_tag' => NULL, 'name' => 'Components', 'tag' => 'components', 'status' => 'ACTIVE', 'created_at' => '2020-01-07 00:00:00', 'updated_at' => '2020-01-07 00:00:00', 'deleted_at' => NULL),
            array('id' => '57', 'parent_tag' => 'records-mgt', 'name' => 'Towns', 'tag' => 'setup.free.towns', 'status' => 'ACTIVE', 'created_at' => '2020-01-07 00:00:00', 'updated_at' => '2020-01-07 00:00:00', 'deleted_at' => NULL),
            array('id' => '58', 'parent_tag' => 'records-mgt', 'name' => 'Facility Management', 'tag' => 'setup.facility', 'status' => 'ACTIVE', 'created_at' => '2020-01-07 00:00:00', 'updated_at' => '2020-01-07 00:00:00', 'deleted_at' => NULL),
            array('id' => '59', 'parent_tag' => 'records-mgt', 'name' => 'Accreditations', 'tag' => 'setup.accreditations', 'status' => 'ACTIVE', 'created_at' => '2020-01-07 00:00:00', 'updated_at' => '2020-01-07 00:00:00', 'deleted_at' => NULL),
            array('id' => '60', 'parent_tag' => 'records-mgt', 'name' => 'Religions', 'tag' => 'setup.free.religions', 'status' => 'ACTIVE', 'created_at' => '2020-01-07 00:00:00', 'updated_at' => '2020-01-07 00:00:00', 'deleted_at' => NULL),
            array('id' => '61', 'parent_tag' => 'records-mgt', 'name' => 'Relationships', 'tag' => 'setup.free.relationships', 'status' => 'ACTIVE', 'created_at' => '2020-01-07 00:00:00', 'updated_at' => '2020-01-07 00:00:00', 'deleted_at' => NULL),
            array('id' => '62', 'parent_tag' => 'records-mgt', 'name' => 'Titles', 'tag' => 'setup.free.titles', 'status' => 'ACTIVE', 'created_at' => '2020-01-07 00:00:00', 'updated_at' => '2020-01-07 00:00:00', 'deleted_at' => NULL),
            array('id' => '63', 'parent_tag' => 'records-mgt', 'name' => 'Departments', 'tag' => 'setup.departments', 'status' => 'ACTIVE', 'created_at' => '2020-01-07 00:00:00', 'updated_at' => '2020-01-07 00:00:00', 'deleted_at' => NULL),
            array('id' => '64', 'parent_tag' => 'records-mgt', 'name' => 'Age Groups', 'tag' => 'setup.agegroups', 'status' => 'ACTIVE', 'created_at' => '2020-01-07 00:00:00', 'updated_at' => '2020-01-07 00:00:00', 'deleted_at' => NULL),
            array('id' => '65', 'parent_tag' => 'records-mgt', 'name' => 'Educational Levels', 'tag' => 'setup.free.educationallevels', 'status' => 'ACTIVE', 'created_at' => '2020-01-07 00:00:00', 'updated_at' => '2020-01-07 00:00:00', 'deleted_at' => NULL),
            array('id' => '66', 'parent_tag' => 'acct-mgt', 'name' => 'Banks', 'tag' => 'setup.free.banks', 'status' => 'ACTIVE', 'created_at' => '2020-01-07 00:00:00', 'updated_at' => '2020-01-07 00:00:00', 'deleted_at' => NULL),
            array('id' => '67', 'parent_tag' => 'acct-mgt', 'name' => 'Bank Branches', 'tag' => 'setup.free.bankbranches', 'status' => 'ACTIVE', 'created_at' => '2020-01-07 00:00:00', 'updated_at' => '2020-01-07 00:00:00', 'deleted_at' => NULL),
            array('id' => '68', 'parent_tag' => 'records-mgt', 'name' => 'Languages', 'tag' => 'setup.free.languages', 'status' => 'ACTIVE', 'created_at' => '2020-01-07 00:00:00', 'updated_at' => '2020-01-07 00:00:00', 'deleted_at' => NULL),
            array('id' => '70', 'parent_tag' => 'users-mgt', 'name' => 'Staff categories', 'tag' => 'setup.free.staffcategories', 'status' => 'ACTIVE', 'created_at' => '2020-01-07 00:00:00', 'updated_at' => '2020-01-07 00:00:00', 'deleted_at' => NULL),
            array('id' => '71', 'parent_tag' => 'users-mgt', 'name' => 'Professions', 'tag' => 'setup.free.professions', 'status' => 'ACTIVE', 'created_at' => '2020-01-07 00:00:00', 'updated_at' => '2020-01-07 00:00:00', 'deleted_at' => NULL),
            array('id' => '72', 'parent_tag' => 'users-mgt', 'name' => 'Staff Types', 'tag' => 'setup.stafftypes', 'status' => 'ACTIVE', 'created_at' => '2020-01-07 00:00:00', 'updated_at' => '2020-01-07 00:00:00', 'deleted_at' => NULL),
            array('id' => '73', 'parent_tag' => 'records-mgt', 'name' => 'Hospital Services', 'tag' => 'setup.hospitalservices', 'status' => 'ACTIVE', 'created_at' => '2020-01-07 00:00:00', 'updated_at' => '2020-01-07 00:00:00', 'deleted_at' => NULL),
            array('id' => '74', 'parent_tag' => 'acct-mgt', 'name' => 'Billing Cycles', 'tag' => 'setup.billingcycles', 'status' => 'ACTIVE', 'created_at' => '2020-01-07 00:00:00', 'updated_at' => '2020-01-07 00:00:00', 'deleted_at' => NULL),
            array('id' => '75', 'parent_tag' => 'acct-mgt', 'name' => 'Billing Systems', 'tag' => 'setup.billingsystems', 'status' => 'ACTIVE', 'created_at' => '2020-01-07 00:00:00', 'updated_at' => '2020-01-07 00:00:00', 'deleted_at' => NULL),
            array('id' => '76', 'parent_tag' => 'acct-mgt', 'name' => 'Payment Styles', 'tag' => 'setup.paymentstyles', 'status' => 'ACTIVE', 'created_at' => '2020-01-07 00:00:00', 'updated_at' => '2020-01-07 00:00:00', 'deleted_at' => NULL),
            array('id' => '77', 'parent_tag' => 'records-mgt', 'name' => 'Sponsorship Types', 'tag' => 'setup.sponsorshiptypes', 'status' => 'ACTIVE', 'created_at' => '2020-01-07 00:00:00', 'updated_at' => '2020-01-07 00:00:00', 'deleted_at' => NULL),
            array('id' => '78', 'parent_tag' => 'acct-mgt', 'name' => 'Payment Channels', 'tag' => 'setup.paymentchannels', 'status' => 'ACTIVE', 'created_at' => '2020-01-07 00:00:00', 'updated_at' => '2020-01-07 00:00:00', 'deleted_at' => NULL),
            array('id' => '79', 'parent_tag' => 'acct-mgt', 'name' => 'Funding Types', 'tag' => 'setup.fundingtypes', 'status' => 'ACTIVE', 'created_at' => '2020-01-07 00:00:00', 'updated_at' => '2020-01-07 00:00:00', 'deleted_at' => NULL),
            array('id' => '80', 'parent_tag' => 'acct-mgt', 'name' => 'Billing Sponsors', 'tag' => 'setup.billingsponsors', 'status' => 'ACTIVE', 'created_at' => '2020-01-07 00:00:00', 'updated_at' => '2020-01-07 00:00:00', 'deleted_at' => NULL),
            array('id' => '81', 'parent_tag' => 'acct-mgt', 'name' => 'Companies', 'tag' => 'setup.companies', 'status' => 'ACTIVE', 'created_at' => '2020-01-07 00:00:00', 'updated_at' => '2020-01-07 00:00:00', 'deleted_at' => NULL),
            array('id' => '82', 'parent_tag' => 'records-mgt', 'name' => 'Specialties', 'tag' => 'setup.specialties', 'status' => 'ACTIVE', 'created_at' => '2020-01-07 00:00:00', 'updated_at' => '2020-01-07 00:00:00', 'deleted_at' => NULL),
            array('id' => '83', 'parent_tag' => 'records-mgt', 'name' => 'Service Categories', 'tag' => 'setup.servicecategories', 'status' => 'ACTIVE', 'created_at' => '2020-01-07 00:00:00', 'updated_at' => '2020-01-07 00:00:00', 'deleted_at' => NULL),
            array('id' => '84', 'parent_tag' => 'records-mgt', 'name' => 'Service Sub Categories', 'tag' => 'setup.servicesubcategories', 'status' => 'ACTIVE', 'created_at' => '2020-01-07 00:00:00', 'updated_at' => '2020-01-07 00:00:00', 'deleted_at' => NULL),
            array('id' => '85', 'parent_tag' => 'acct-mgt', 'name' => 'Service Prices', 'tag' => 'setup.serviceprices', 'status' => 'ACTIVE', 'created_at' => '2020-01-07 00:00:00', 'updated_at' => '2020-01-07 00:00:00', 'deleted_at' => NULL),
            array('id' => '86', 'parent_tag' => NULL, 'name' => 'Dashboard Staff Categories', 'tag' => 'dasboard.staffcategories', 'status' => 'ACTIVE', 'created_at' => '2020-01-07 00:00:00', 'updated_at' => '2020-01-07 00:00:00', 'deleted_at' => NULL),
            array('id' => '87', 'parent_tag' => 'records-mgt', 'name' => 'ID Types', 'tag' => 'setup.free.idtypes', 'status' => 'ACTIVE', 'created_at' => '2020-01-07 00:00:00', 'updated_at' => '2020-01-07 00:00:00', 'deleted_at' => NULL),
            array('id' => '88', 'parent_tag' => 'records-mgt', 'name' => 'Clinics', 'tag' => 'setup.free.clinics', 'status' => 'ACTIVE', 'created_at' => '2020-01-07 00:00:00', 'updated_at' => '2020-01-07 00:00:00', 'deleted_at' => NULL),
            array('id' => '89', 'parent_tag' => 'lab-mgt', 'name' => 'Lab Parameters', 'tag' => 'setup.free.labparameters', 'status' => 'ACTIVE', 'created_at' => '2020-01-07 00:00:00', 'updated_at' => '2020-01-07 00:00:00', 'deleted_at' => NULL),
            array('id' => '90', 'parent_tag' => 'lab-mgt', 'name' => 'Lab Samples', 'tag' => 'labsamples', 'status' => 'ACTIVE', 'created_at' => '2020-01-07 00:00:00', 'updated_at' => '2020-01-07 00:00:00', 'deleted_at' => NULL),
            array('id' => '91', 'parent_tag' => 'lab-mgt', 'name' => 'Lab Results', 'tag' => 'labresults', 'status' => 'ACTIVE', 'created_at' => '2020-01-07 00:00:00', 'updated_at' => '2020-01-07 00:00:00', 'deleted_at' => NULL),
            array('id' => '92', 'parent_tag' => null, 'name' => 'Inpatients Clinical Notes', 'tag' => 'ipd-clinical-notes', 'status' => 'ACTIVE', 'created_at' => '2020-01-07 00:00:00', 'updated_at' => '2020-01-07 00:00:00', 'deleted_at' => NULL),
            array('id' => '93', 'parent_tag' => 'records-mgt', 'name' => 'E-INUS & CORP', 'tag' => 'setup.free.e-inus', 'status' => 'ACTIVE', 'created_at' => '2020-01-07 00:00:00', 'updated_at' => '2020-01-07 00:00:00', 'deleted_at' => NULL),
            array('id' => '94', 'parent_tag' => 'obs-mgt', 'name' => 'Pregnancy Records', 'tag' => 'preg-rec', 'status' => 'ACTIVE', 'created_at' => '2020-01-07 00:00:00', 'updated_at' => '2020-01-07 00:00:00', 'deleted_at' => NULL),
        );

        Component::insert($components);
        Schema::enableForeignKeyConstraints();
    }
}
