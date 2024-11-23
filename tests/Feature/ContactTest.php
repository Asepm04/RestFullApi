<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ContactTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testCreateContact()
    {
        $this->withHeaders(["authorization"=>"cobain"])
        ->post("/api/contact/create",[
            "first_name"=>"mul1",
            "last_name"=>"1yadi",
            "phone"=>"049887427"
        ])->assertStatus(201)
        ->assertJson(
            [
                "data"=>
                [
                    "first"=>"mul1",
                    "last"=>"1yadi",
                    "phone"=>"049887427"
                ]
            ]
        );
    }
}
