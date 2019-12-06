<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Hospital;
use Faker\Generator as Faker;

$factory->define(Hospital::class, function (Faker $faker) {
    return [
        'name'=>'Apomuden Dev. Hospital',
            'staff_id_prefix'=>'ADH',
            'staff_id_seperator'=>'/',
            'active_cell'=>intval('233'.substr(str_shuffle(intval($faker->e164PhoneNumber)),0,9)),
            'email1'=>$faker->unique()->safeEmail,
    ];
});
