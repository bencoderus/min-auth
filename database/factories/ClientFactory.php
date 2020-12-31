<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use Bencoderus\MinAuth\Models\Client;
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

$factory->define(Client::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'ip' => $faker->unique()->ipv4,
        'api_key' => $faker->md5,
        'is_blacklisted' => false,
    ];
});
