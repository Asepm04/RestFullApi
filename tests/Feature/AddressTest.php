<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\AddressApi;

class AddressTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testCreatedAdressSuccess()

    {
        // Log::info(json_encode(Auth::user()->contact()->pluck("id")));
        // $user = Auth::user();
        $this->withHeaders(["authorization"=>"cobain"])
        ->post("/api/users/contact/5/address",
        [
            "street"=>"test",
            "city"=>"test",
            "province"=>"test",
            "country"=>"test",
            "postal_code"=>"test"
        ])->assertStatus(201)
        ->assertJson(
            [
                "data"=>
                [
                    "city"=>"test",
                    "province"=>"test",
                    "country"=>"test",
                    "postal_code"=>"test"
                ]
            ]
        );
    }

    public function testCreatedAdressFailed()

    {
        // Log::info(json_encode(Auth::user()->contact()->pluck("id")));
        // $user = Auth::user();
        $this->withHeaders(["authorization"=>"contact"])
        ->post("/api/users/contact/5/address",
        [
            "street"=>"test",
            "city"=>"test",
            "province"=>"test",
            "country"=>"test",
            "postal_code"=>"test"
        ])->assertStatus(404)
        ->assertJson(
            [
                "errors"=>"not found"
            ]
        );
    }

    public function testCreatedAdressgagal()

    {
        // Log::info(json_encode(Auth::user()->contact()->pluck("id")));
        // $user = Auth::user();
        $this->withHeaders(["authorization"=>"cobain"])
        ->post("/api/users/contact/5/address",
        [
            "street"=>"test",
            "city"=>"test",
            "province"=>"test",
            "country"=>"",
            "postal_code"=>"test"
        ])->assertStatus(400)
        ->assertJson(
            [
               [ "country"=>["The country field is required."]]
            ]
        );
    }

    public function testGet()
    {
        $data = AddressApi::limit(1)->first();
        $this->withHeaders(["authorization"=>"cobain"])
        ->get('/api/users/contact/'.$data->contact_id.'/address/'.$data->id)
        ->assertStatus(200)
        ->assertJson(
            [
            
            ]
        );
    }
    public function testGetFailed()
    {
        $data = AddressApi::limit(1)->first();
        $this->withHeaders(["authorization"=>"cobain"])
        ->get('/api/users/contact/'.$data->contact_id.'/address/89')
        ->assertStatus(404)
        ->assertJson(
            [
                "errors"=>"not found"
            ]
        );
    }
}
