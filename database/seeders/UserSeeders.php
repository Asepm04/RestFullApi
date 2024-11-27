<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ContactApi;
use Illuminate\Support\Facades\Auth;

class UserSeeders extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($a=1; $a<20;$a++)
        {
            ContactApi::create(
                ["first_name"=>"yad",
                "last_name"=>"yad@com",
                "phone"=>"12345",
                "user_id"=> 4
                ]
            );
        }
    }
}
