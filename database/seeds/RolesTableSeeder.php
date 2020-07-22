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
        $payload= [
            ['name' => 'Admin'],
            ['name' => 'Nurse'],
            ['name' => 'Doctor'],
            ['name' => 'Lab Technologist'],
            ['name' => 'Lab Technician'],
            ['name' => 'Biomedical Scientist'],
            ['name' => 'Cachier'],
            ['name' => 'Records Attendant'],
            ['name' => 'Records Supervisor'],
            ['name' => 'Records Head']
        ];
        foreach($payload as $row)
        Role::firstOrNew($row);
    }
}
