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
            ['name'=>'Main Dashboard','tag'=>'dashboard.main','created_at'=>now(),'updated_at'=>now()],

            //==Facility Management
            ['name'=>'Facility Details','tag'=>'facility.detail','created_at'=>now(),'updated_at'=>now()],
            ['name'=>'Numbering Settings','tag'=>'facility.numbering','created_at'=>now(),'updated_at'=>now()],
            ['name'=>'Consultation Components','tag'=> 'facility.consultation.components','created_at'=>now(),'updated_at'=>now()],
            ['name'=>'Consultation Rooms','tag'=> 'facility.consultation.rooms','created_at'=>now(),'updated_at'=>now()],
            ['name'=>'Nhis Accreditation Settings','tag'=> 'facility.nhis.accreditation','created_at'=>now(),'updated_at'=>now()],
            ['name'=>'Billing Cycle','tag'=> 'facility.funding.billing.cycle','created_at'=>now(),'updated_at'=>now()],
            ['name'=>'Billing System','tag'=> 'facility.funding.billing.system','created_at'=>now(),'updated_at'=>now()],
            ['name'=>'Funding Type','tag'=> 'facility.funding.type','created_at'=>now(),'updated_at'=>now()],
            ['name'=>'Payment Channel','tag'=> 'facility.funding.channel','created_at'=>now(),'updated_at'=>now()],
            ['name'=>'Payment Style','tag'=> 'facility.funding.style','created_at'=>now(),'updated_at'=>now()],
            ['name'=>'Allow Installment Type','tag'=> 'facility.funding.installment','created_at'=>now(),'updated_at'=>now()],

            //==System Configurations
            //Records
            ['name' => 'Town', 'tag' => 'config.record.town', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'District', 'tag' => 'config.record.district', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Religion', 'tag' => 'config.record.religion', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Title', 'tag' => 'config.record.title', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Educational Level', 'tag' => 'config.record.education', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'ID Type', 'tag' => 'config.record.id.type', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Language', 'tag' => 'config.record.language', 'created_at' => now(), 'updated_at' => now()],

            //Accounts
            ['name' => 'Hospital Services', 'tag' => 'config.account.hospital.service', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Services Category', 'tag' => 'config.account.service.category', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Services Sub Category', 'tag' => 'config.account.service.sub.category', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Services and Pricing', 'tag' => 'config.account.service', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Educational Level', 'tag' => 'config.account.education', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Sponsor Policy', 'tag' => 'config.account.sponsor.policy', 'created_at' => now(), 'updated_at' => now()],

            //Laboratory Setup
            ['name' => 'Lab Parameters', 'tag' => 'config.lab.parameter', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Lab Service Parameter Map', 'tag' => 'config.lab.parameter.map', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Sample Types', 'tag' => 'config.lab.sample.type', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Lab Service Sample-Type Map', 'tag' => 'config.lab.service.sample.type.map', 'created_at' => now(), 'updated_at' => now()],

            //Stores
            ['name' => 'Product Type and Category', 'tag' => 'config.store.product.type.category', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Product Form and Unit', 'tag' => 'config.store.product.form.unit', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Products', 'tag' => 'config.store.product', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Medicine Route', 'tag' => 'config.store.medicine.route', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Store Users', 'tag' => 'config.store.users', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Stores', 'tag' => 'config.store.store', 'created_at' => now(), 'updated_at' => now()],

            //EINSU & CORP.
            ['name' => 'NHIS Provider Level', 'tag' => 'config.einsu.nhis.provider.level', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'NHIS MDC', 'tag' => 'config.einsu.nhis.mdc', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'NHIS Tariff', 'tag' => 'config.einsu.nhis.tariff', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'NHIS Mapping', 'tag' => 'config.einsu.nhis.mapping', 'created_at' => now(), 'updated_at' => now()],

            //Other
            ['name' => 'Age Group', 'tag' => 'config.other.age.group', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Age Classification', 'tag' => 'config.other.age.classification', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Age Category', 'tag' => 'config.other.age.category', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Profession', 'tag' => 'config.other.profession', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Medical Sponsors', 'tag' => 'config.other.medical.sponsor', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Banks', 'tag' => 'config.other.bank', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Banks Branches', 'tag' => 'config.other.bank.branch', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Clinics', 'tag' => 'config.other.clinic', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Clinics Types', 'tag' => 'config.other.clinic.type', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Clinics Service', 'tag' => 'config.other.clinic.service', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Accreditations', 'tag' => 'config.other.accreditation', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Companies', 'tag' => 'config.other.company', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Departments', 'tag' => 'config.other.department', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Districts', 'tag' => 'config.other.district', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Specialties', 'tag' => 'config.other.specialty', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Sponsorship Types', 'tag' => 'config.other.sponsorship.type', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Staff Category', 'tag' => 'config.other.staff.category', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Staff Types', 'tag' => 'config.other.staff.types', 'created_at' => now(), 'updated_at' => now()],

            //Clinicals
            ['name' => 'Service Component Map', 'tag' => 'config.clinic.service.component.map', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Questionaire', 'tag' => 'config.clinic.questionaire', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Medical History Category', 'tag' => 'config.clinic.medical.history.category', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Allergy History Category', 'tag' => 'config.clinic.allergy.history.category', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Allergy History', 'tag' => 'config.clinic.allergy.history', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Family History Category', 'tag' => 'config.clinic.family.history.category', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Family History', 'tag' => 'config.clinic.family.history', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Medicine History Category', 'tag' => 'config.clinic.medicine.history.category', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Social History Category', 'tag' => 'config.clinic.social.history.category', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Surgical History Category', 'tag' => 'config.clinic.surgical.history.category', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Illness Types', 'tag' => 'config.clinic.illness.type', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Discharge Reasons', 'tag' => 'config.clinic.discharge.reason', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Complaint Type', 'tag' => 'config.clinic.conplaint.type', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Complaints', 'tag' => 'config.clinic.conplaint', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Physical Examination Category', 'tag' => 'config.clinic.physical.examination.category', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Physical Examination Type', 'tag' => 'config.clinic.physical.examination.type', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'MOH GHS Grouping', 'tag' => 'config.clinic.moh.ghs.groupings', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'ICD 10 Categories', 'tag' => 'config.clinic.icd.10.category', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'ICD 10 Groupings', 'tag' => 'config.clinic.icd.10.grouping', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Diseases', 'tag' => 'config.clinic.disease', 'created_at' => now(), 'updated_at' => now()],


            //Obstetric Setting
            ['name' => 'Gestational Week', 'tag' => 'config.obstetric.gestation', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Birth Places', 'tag' => 'config.obstetric.birth.places', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Delivery Modes', 'tag' => 'config.obstetric.delivery.modes', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Delivery Outcomes', 'tag' => 'config.obstetric.delivery.outcomes', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Questionaire', 'tag' => 'config.obstetric.questionaire', 'created_at' => now(), 'updated_at' => now()],

            //==User Management/Security
            ['name' => 'Users', 'tag' => 'security.user', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Staff Remarks', 'tag' => 'security.user.remark', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Roles', 'tag' => 'security.role', 'created_at' => now(), 'updated_at' => now()],
            //['name' => 'Permissions', 'tag' => 'security.permission', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Modules', 'tag' => 'security.module', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Components', 'tag' => 'security.component', 'created_at' => now(), 'updated_at' => now()],

            //==Records Mangement
            ['name' => 'Folders', 'tag' => 'record.folder', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Patients', 'tag' => 'record.patient', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Sponsorship Permit', 'tag' => 'record.sponsorship.permit', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Request Consultation', 'tag' => 'record.request.consultation', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Appointments', 'tag' => 'record.appointment', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Walk-In Registration', 'tag' => 'record.walkin.registration', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Reports', 'tag' => 'record.report', 'created_at' => now(), 'updated_at' => now()],

            //==OPD
            ['name' => 'Vitals', 'tag' => 'opd.vital', 'created_at' => now(), 'updated_at' => now()],

            //==Clinical Management
            ['name' => 'Consultation', 'tag' => 'clinical.consultation', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'IVF Consultation', 'tag' => 'clinical.ivf.consultation', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Urgent Care Note', 'tag' => 'clinical.note.urgent.care', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Treatment Plan Note', 'tag' => 'clinical.note.treatment.plan', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Progress Note', 'tag' => 'clinical.note.progress', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Admission Note', 'tag' => 'clinical.note.admission', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Procurement Note', 'tag' => 'clinical.note.procurement', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Physician Note', 'tag' => 'clinical.note.physician', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Nursing Note', 'tag' => 'clinical.note.nursing', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Delivery Note', 'tag' => 'clinical.note.delivery', 'created_at' => now(), 'updated_at' => now()],


            //==Obstetrics Management
            ['name' => 'Family Information', 'tag' => 'obstetric.family.information', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Obstetric History', 'tag' => 'obstetric.history', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Pregnancy Records', 'tag' => 'obstetric.pregancy.record', 'created_at' => now(), 'updated_at' => now()],

            //==Laboratory Management
            ['name' => 'Laboratory', 'tag' => 'lab.lab', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Test Samples', 'tag' => 'lab.sample', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Test Results', 'tag' => 'lab.result', 'created_at' => now(), 'updated_at' => now()],

            //==Account Management
            //Patient Payment
            ['name' => 'Patient Payment', 'tag' => 'account.patient.payment', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Patient Deposit', 'tag' => 'account.patient.deposit', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Patient Discount', 'tag' => 'account.patient.discount', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Patient Ascond', 'tag' => 'account.patient.abscond', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Patient Refund', 'tag' => 'account.patient.refund', 'created_at' => now(), 'updated_at' => now()],

            //==Stores Management
            ['name' => 'Stock Adjustment', 'tag' => 'account.stock.adjustment', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Requisition', 'tag' => 'account.requisition', 'created_at' => now(), 'updated_at' => now()],
        );

        Component::insert($components);
        Schema::enableForeignKeyConstraints();
    }
}
