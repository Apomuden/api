<?php

use App\Models\Company;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Company::insert([
            [
                "name"=>"Acacia Health Insurance Limited",
                "phone"=>"233233008821",
                "email"=>"info@acaciahealthinsurance.com",
                "location_address"=>"No 5 Asoye Lane, East Legon",
                "website"=>'ahighana.com'
            ],
            [
                "name"=>"Ace Medical Insurance",
                "phone"=>"233556778906",
                "email"=>"info@acemedinsurance.com",
                "location_address"=>"No. 9033 Octagon, Barnes Road, Accra Central",
                "website"=>'acemedinsurance.com'

            ],
            [
                "name"=>"Apex Health Insurance Limited",
                "phone"=>"233302544410",
                "email"=>"info@apexhealthghana.com",
                "location_address"=>"No. 9033 Octagon, Barnes Road, Accra Central",
                "website"=>'apexhealthghana.com'

            ]
        ]);
    }
}
