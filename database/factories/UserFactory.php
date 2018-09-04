<?php

use Faker\Generator as Faker;

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

$factory->defineAs(App\User::class, 'admin',   function (Faker $faker) {
    return [
        'name' => 'admin',
        'email' => 'yastrigun@ukr.net',
        'password' => bcrypt('admin'),
        'remember_token' => str_random(10),
    ];
});
