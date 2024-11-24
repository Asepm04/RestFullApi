<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeders extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create(
            ["name"=>"yad",
            "email"=>"yad@com",
            "password"=>"12345",
            "remember_token"=>"contact"]
        );
    }
}
