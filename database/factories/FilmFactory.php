<?php 
$factory->define(App\Film::class, function (Faker\Generator $faker) {
    static $password;
    $name = $faker->name;
    return [
        'name' => $name,
        'description' => $faker->paragraph,
        'release_date' => $faker->date,
        'ticket_price' => $faker->randomFloat(2, 10, 90),
        'country' => $faker->country,
        'photo' => $faker->Image,
        'rating' => $faker->numberBetween(1, 5),
        'slug' => str_slug($name)
    ];
});

$factory->define(App\FilmComment::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'comments' => $faker->sentence(20),
    ];
});

$factory->define(App\FilmGenre::class, function (Faker\Generator $faker) {
    return [
        'genre' => $faker->word,
    ];
});