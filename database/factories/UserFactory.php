<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Country;
use App\Models\Department;
use App\Models\EducationalLevel;
use App\Models\Profession;
use App\Models\Region;
use App\Models\Religion;
use App\Models\Role;
use App\Models\StaffType;
use App\Models\Title;
use App\Models\User;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(User::class, function (Faker $faker) {
    $gender = $faker->randomElement($array = array ('MALE', 'FEMALE'));

    $marital = $faker->randomElement($array =['SINGLE','MARRIED','DIVORCED','WIDOW','WIDOWER','OTHER']);

    if($gender=='MALE')
    $title_id=Title::where('name','Mr')->first()->id;
    elseif($marital=='MARRIED')
    $title_id=Title::where('name','Mrs')->first()->id;
    else
    $title_id=Title::where('name','Madam')->first()->id;


    $country=Country::where('country_code','gh')->first();
    return [
        'firstname' =>$faker->firstName($gender),
        'surname' =>$faker->lastName,
        'email' => $faker->unique()->safeEmail,
        'dob'=>$faker->dateTimeBetween('-30 years','now', $timezone = 'Africa/Accra'),
        'gender'=>$gender,
        'title_id'=>$title_id,
        'religion_id'=>Religion::inRandomOrder()->first()->id,
        'profession_id'=>Profession::inRandomOrder()->first()->id,
        'educational_level_id'=>EducationalLevel::inRandomOrder()->first()->id,
        'residence'=>$faker->streetAddress,
        'origin_country_id'=>$country->id,
        'origin_region_id'=>$country->regions()->inRandomOrder()->first()->id,
        'department_id'=>Department::inRandomOrder()->first()->id,
        'staff_type_id'=>StaffType::inRandomOrder()->first()->id,
        'role_id'=>Role::inRandomOrder()->first()->id,
        'expires'=>false,
        'marital'=>$marital,
        'password'=>'secret',
        'active_cell'=>intval('233'.substr(str_shuffle(intval($faker->e164PhoneNumber)),0,9)),
        'username'=>strtolower(substr(str_shuffle(Str::random(100)),0,5)),

    ];
});
