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
        "name"=>"yadi2",
        "email"=>"yadi332@com",
        "password"=>"123456",
        "remember_token"=>"cobain"
    ])->assertStatus(200)
    ->assertJson(
        [
            "data"=>
            [
                "name"=>"yadi2",
                "email"=>"yadi332@com",
                "remember_token"=>"cobain"
            ]
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
                "id"=>"1",
                "name"=>"yadi",
                "email"=>"yadi@com",
                "token"=>"b8a72b7a-ba55-47a4-80a0-60c62a4563cf"
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

   public function testGetAuth(){
    $this->withHeaders(['authorization'=>"test"])->post("/api/users/get")
    ->assertStatus(200)
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

   public function testGetAuthFailed(){
    $this->withHeaders(["authorization"=>"get"])->post("/api/users/get")
    ->assertStatus(400)
    ->assertJson(
        [
            "errors"=>"unauthorize"
        ]
            );
   }

   public function testUpdate()
   {
    $this->withHeaders(["authorization"=>"cobain"])
    ->patch("/api/users/get",[
        "name"=>"yadi00"
    ])->assertStatus(200)
    ->assertJson(
        [
            "data"=>
            [
                "name"=>"yadi00",
                "email"=>"yadi332@com"
            ]
        ]
    );
   }

   public function testLogout()
   {
    $this->withHeaders(["authorization"=>"test"])
    ->delete("/api/users/logout",[])
    ->assertStatus(200)
    ->assertJson(["data"=>true]);
   }
}
