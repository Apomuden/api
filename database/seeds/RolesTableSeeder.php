<?php

use App\Models\Role;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::insert([
            ['name' => 'Admin'],
            ['name' => 'Nurse'],
            ['name' => 'Doctor'],
            ['name' => 'Lab Technologist'],
            ['name' => 'Lab Technician'],
            ['name' => 'Biomedical Scientist']
        ]);
    }
}
