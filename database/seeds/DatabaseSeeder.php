<?php

use App\Models\AgeGroup;
use App\Models\EducationalLevel;
use App\Models\Title;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        // $this->call(CountriesTableSeeder::class);
        // $this->call(RegionsTableSeeder::class);
        // $this->call(HospitalTableSeeder::class);
        // $this->call(RolesTableSeeder::class);
        $this->call(PermissionTableSeeder::class);
        // $this->call(AgeGroupTableSeeder::class);
        // $this->call(sponsorshipTypesSeeder::class);
        // $this->call(billingCycleSeeder::class);
        // $this->call(paymentStyleSeeder::class);
        // $this->call(paymentChannelSeeder::class);
        // $this->call(billingSystemSeeder::class);
        // $this->call(id_typesTableSeeder::class);
        // $this->call(FundingTypeTableSeeder::class);
        // $this->call(TitleTableSeeder::class);
        // $this->call(StaffCategoriesTableSeeder::class);
        // $this->call(StaffTypesTableSeeder::class);
        // $this->call(ProfessionsTableSeeder::class);
        // $this->call(DepartmentsTableSeeder::class);
        // $this->call(ReligionTableSeeder::class);
        // $this->call(EducationalLevelsTableSeeder::class);
        // $this->call(UsersTableSeeder::class);
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
