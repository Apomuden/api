<?php

use App\Models\EducationalLevel;
use App\Models\Title;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(CountriesTableSeeder::class);
        $this->call(RegionsTableSeeder::class);
        $this->call(HospitalTableSeeder::class);
        $this->call(RolesTableSeeder::class);
        $this->call(PermissionTableSeeder::class);
        $this->call(FundingTypeTableSeeder::class);
        $this->call(TitleTableSeeder::class);
        $this->call(StaffCategoriesTableSeeder::class);
        $this->call(StaffTypesTableSeeder::class);
        $this->call(ProfessionsTableSeeder::class);
        $this->call(DepartmentsTableSeeder::class);
        $this->call(ReligionTableSeeder::class);
        $this->call(EducationalLevelsTableSeeder::class);
        $this->call(UsersTableSeeder::class);
    }
}
