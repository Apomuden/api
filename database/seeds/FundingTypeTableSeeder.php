<?php

use App\Models\BillingCycle;
use App\Models\BillingSystem;
use App\Models\FundingType;
use App\Models\PaymentChannel;
use App\Models\PaymentStyle;
use App\Models\SponsorshipType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class FundingTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        @FundingType::insert([
            ['name'=>'Cash/Prepaid',
            'sponsorship_type_id'=>SponsorshipType::where('name','patient')->first()->id,
            'billing_system_id'=>BillingSystem::where('name','UNBUNDLED/ITEMIZE')->first()->id,
            'billing_cycle_id'=>BillingCycle::where('name','Daily')->first()->id,
            'payment_style_id'=>PaymentStyle::where('name','Prepaid')->first()->id,
            'payment_channel_id'=>PaymentChannel::where('name','Cash')->first()->id],

            ['name'=>'NHIS Self',
            'sponsorship_type_id'=>SponsorshipType::where('name','Government Insurance')->first()->id,
            'billing_system_id'=>BillingSystem::where('name','GHANA RELATED DIAGNOSIS GROUPING (GDRG)')->first()->id,
            'billing_cycle_id'=>BillingCycle::where('name','Daily')->first()->id,
            'payment_style_id'=>PaymentStyle::where('name','Postpaid')->first()->id,
            'payment_channel_id'=>PaymentChannel::where('name','Cheque')->first()->id],

            ['name'=>'NHIS Baby',
            'sponsorship_type_id'=>SponsorshipType::where('name','Government Insurance')->first()->id,
            'billing_system_id'=>BillingSystem::where('name','GHANA RELATED DIAGNOSIS GROUPING (GDRG)')->first()->id,
            'billing_cycle_id'=>BillingCycle::where('name','Daily')->first()->id,
            'payment_style_id'=>PaymentStyle::where('name','Postpaid')->first()->id,
            'payment_channel_id'=>PaymentChannel::where('name','Cheque')->first()->id],

            ['name'=>'Coporate Self','sponsorship_type_id'=>SponsorshipType::where('name','Government Insurance')->first()->id,
            'billing_system_id'=>BillingSystem::where('name','GHANA RELATED DIAGNOSIS GROUPING (GDRG)')->first()->id,
            'billing_cycle_id'=>BillingCycle::where('name','Daily')->first()->id,
            'payment_style_id'=>PaymentStyle::where('name','Postpaid')->first()->id,
            'payment_channel_id'=>PaymentChannel::where('name','Cheque')->first()->id],

            ['name'=>'Corporate Dependant',
            'sponsorship_type_id'=>SponsorshipType::where('name','Government Insurance')->first()->id,
            'billing_system_id'=>BillingSystem::where('name','GHANA RELATED DIAGNOSIS GROUPING (GDRG)')->first()->id,
            'billing_cycle_id'=>BillingCycle::where('name','Daily')->first()->id,
            'payment_style_id'=>PaymentStyle::where('name','Postpaid')->first()->id,
            'payment_channel_id'=>PaymentChannel::where('name','Cheque')->first()->id],

            ['name'=>'Coporate Self','sponsorship_type_id'=>SponsorshipType::where('name','Private Insurance')->first()->id,
            'billing_system_id'=>BillingSystem::where('name','GHANA RELATED DIAGNOSIS GROUPING (GDRG)')->first()->id,
            'billing_cycle_id'=>BillingCycle::where('name','Daily')->first()->id,
            'payment_style_id'=>PaymentStyle::where('name','Postpaid')->first()->id,
            'payment_channel_id'=>PaymentChannel::where('name','Cheque')->first()->id],

            ['name'=>'Corporate Dependant',
            'sponsorship_type_id'=>SponsorshipType::where('name','Private Insurance')->first()->id,
            'billing_system_id'=>BillingSystem::where('name','GHANA RELATED DIAGNOSIS GROUPING (GDRG)')->first()->id,
            'billing_cycle_id'=>BillingCycle::where('name','Daily')->first()->id,
            'payment_style_id'=>PaymentStyle::where('name','Postpaid')->first()->id,
            'payment_channel_id'=>PaymentChannel::where('name','Cheque')->first()->id],

        ]);
    }
}
