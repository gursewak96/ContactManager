<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Contact;
use Faker\Generator as Faker;
use App\User;

$factory->define(Contact::class, function (Faker $faker) {
    return [
        'user_id'=> factory(User::class),
        'name'=> $faker->name,
        'email'=> $faker->email,
        'birthday'=>"11/02/2001",
        'company'=>$faker->company
    ];
});
