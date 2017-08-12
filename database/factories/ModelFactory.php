<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\User::class, function (Faker\Generator $faker)
{
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
        'role_id' => 3
    ];
});

$factory->define(App\Article::class, function (Faker\Generator $faker)
{

    return [
        'title' => $faker->sentence(3),
        'slug' => $faker->slug,
        'description' => $faker->sentence(10, true),
        'keywords' => $faker->word(5),
        'body' => $faker->text,
        'user_id' => factory(App\User::class)->create()->id
    ];
});

$factory->define(App\Tag::class, function (Faker\Generator $faker)
{
    return [
        'name' => $faker->word
    ];
});