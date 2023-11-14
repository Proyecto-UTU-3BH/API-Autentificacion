<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Laravel\Passport\Client;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        /*\App\Models\User::factory(10)->create();
        \App\Models\User::factory(1)->create([
            "name" => "usuario",
            "email" => "usuario@email.com"
        ]);*/

        \App\Models\User::factory(1)->create([
            "usuario" =>"transito@adinet.com",
            "password" =>Hash::make("12345678")
        ]);

       /* Client::create([
            'id' => 1,
            'name' => 'Tests',
            'secret' => "x21mzlq0ijQMy6IewvJcp5X9pzxjo79rfrldaboD",
            'redirect' => 'http://localhost',
            'provider' => 'users',
            'password_client' => true,
            'personal_access_client' => false,
            'revoked' => false
        ]);*/

    }
}
