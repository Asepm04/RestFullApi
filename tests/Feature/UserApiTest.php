<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserApiTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
   public function testRegisterUserSuccess()
   {
    $this->post("/api/users/register",[
        "name"=>"yadi",
        "email"=>"yadi@com",
        "password"=>"123456",
        "remember_token"=>"test"
    ])->assertStatus(200)
    ->assertJson(
        [
            "name"=>"yadi",
            "email"=>"yadi@com",
            "remember_token"=>"test"
        ]
    );
   }
}
