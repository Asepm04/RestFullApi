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
   public function testRegisterUserAready()
   {
    $this->post("/api/users/register",[
        "name"=>"yadi",
        "email"=>"yadi@com",
        "password"=>"123456",
        "remember_token"=>"test"
    ])->assertStatus(400)
    ->assertJson(
        [
           "errors"=>[
            "message"=>"email is already"
           ]
        ]
    );
   }

   public function testRegisterUserFailed()
   {
    $this->post("/api/users/register",[
        "name"=>"",
        "email"=>"",
        "password"=>"",
        "remember_token"=>""
    ])
    ->assertJson(
        [[
           
                "name"=> [
                    "The name field is required."
                ],
                "email"=> [
                    "The email field is required."
                ],
                "password"=> [
                    "The password field is required."
                ],
                "remember_token"=> [
                    "The remember token field is required."
                ]
            ]]
        
    )->assertStatus(400);
   }

   public function testloginSuccess()
   {
    $this->post("api/users/login",
    [
        "email"=>"yadi@com",
        "password"=>"123456"
    ])->assertStatus(200)
    ->assertJson(
        [
            "data"=>
            [
                "name"=>"yadi",
                "email"=>"yadi@com"
            ]
        ]
    );
   }
   public function testloginFailed()
   {
    $this->post("api/users/login",
    [
        "email"=>"i@com",
        "password"=>"123456"
    ])->assertStatus(400)
    ->assertJson(
        
           ["errors"=>"email or password is wrong"]
        
    );
   }
}
