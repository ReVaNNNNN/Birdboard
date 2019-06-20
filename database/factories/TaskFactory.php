<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */


use App\Project;
use Faker\Generator as Faker;

$factory->define(App\Task::class, function (Faker $faker) {
    return [
        'body' => $faker->sentence,
        'project_id' => factory(Project::class)
    ];
});
