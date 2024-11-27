<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Database\Seeders\UserSeeders;
use App\Models\ContactApi;

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
            "first_name"=>"mul12",
            "last_name"=>"1yadi",
            "phone"=>"049887427"
        ])->assertStatus(201)
        ->assertJson(
            [
                "data"=>
                [
                    "first"=>"mul12",
                    "last"=>"1yadi",
                    "phone"=>"049887427"
                ]
            ]
        );
    }
    public function testCreateContactFailed()
    {
        $this->withHeaders(["authorization"=>"cobain"])
        ->post("/api/contact/create",[
            "first_name"=>"",
            "last_name"=>"",
            "phone"=>""
        ])->assertStatus(400)
        ->assertJson(

                [[
                    "first_name"=>["The first name field is required."],
                    "last_name"=>["The last name field is required."],
                    "phone"=>["The phone field is required."],
                ]]

        );
    }
    public function testCreateContactAuth()
    {
        $this->withHeaders(["authorization"=>"test"])
        ->post("/api/contact/create",[
            "first_name"=>"mul1",
            "last_name"=>"1yadi",
            "phone"=>"049887427"
        ])->assertStatus(400)
        ->assertJson(
            [
                "errors"=>"unauthorize"
            ]
        );
    }

    public function testGet()
    {
        // $this->seed(UserSeeders::class);
        // $this->testCreateContact();
        //karena sudah diinput
        $contact = ContactApi::where("id","5")->first();

        $this->withHeaders(["authorization"=>"cobain"])
        ->get("/api/contact/get/".$contact['id'])
        ->assertStatus(200)
        ->assertJson(
            [
                "data"=>
                [
                    "first"=>"yadi yadi",
                    "last"=>"1yadi",
                    "phone"=>"049887427"
                ]

            ]
        );


    }
    public function testGetNotFound()
    {
        // $this->seed(UserSeeders::class);
        // $this->testCreateContact();
        //karena sudah diinput
        $contact = ContactApi::where("id","6")->first();

        $this->withHeaders(["authorization"=>"cobain"])
        ->get("/api/contact/get/".$contact['id'])
        ->assertStatus(404)
        ->assertJson(
            [
                "errors"=>"not found"

            ]
        );


    }

    public function testUdpate()
    {
        $contact = ContactApi::where("id",4)->first();
        $this->withHeaders(["authorization"=>"cobain"])
        ->post("/api/contact/update/".$contact['id'],[
            "first_name"=>"yadi teest"
        ])
        ->assertStatus(200)
        ->assertJson(
            [
                "data"=>
                [
                    "first"=>"yadi teest",
                    "last"=>"1yadi",
                    "phone"=>"049887427"
                ]
            ]
        );
    }
    public function testUdpateFailed()
    {
        $contact = ContactApi::where("id",4)->first();
        $this->withHeaders(["authorization"=>"contact"])
        ->post("/api/contact/update/".$contact['id'],[
            "first_name"=>"yadi teest"
        ])
        ->assertStatus(404)
        ->assertJson(
            [
                "errors"=>"not found"
            ]
        );
    }

    public function testDeletedContact()
    {
        $contact = ContactApi::where("id",4)->first();
        $this->withHeaders(["authorization"=>"cobain"])
        ->delete("/api/contact/delete/".$contact['id'],[])
        ->assertStatus(200)
        ->assertJson(
            [
                "data"=>"true"
            ]
        );
    }

    public function testPaginate()
    {
        $this->withHeaders(["authorization"=>"cobain"])
        ->get("/api/contact/paginate?nama=mul1")
        ->assertStatus(200);
    }

}
