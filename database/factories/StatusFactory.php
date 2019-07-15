<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(Model::class, function (Faker $faker) {
    $date_time = $faker->date . ' ' . $faker->time;
    return [
        'title'      => $faker->text('收入'),
        'jine'       => $faker->text(),
        'content'    => $faker->text(),
        'time'       => $faker->time(),
        'created_at' => $date_time,
        'updated_at' => $date_time,
    ];
});
