<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ContactApi;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Http\Resources\AddressResource;
use App\Http\Requests\AddressRequest;
use App\Models\AddressApi;


class AddressController extends Controller
{
    public function createAddress($idcontact,AddressRequest $request)
    {
        $data = $request->validated();
        $user = Auth::user();
        Log::info(json_encode($user->id));
        $contact = ContactApi::where("user_id",$user->id)->where("id",$idcontact)->first();
        if(!$contact)
        {
            throw new HttpResponseException(
                response()->json(["errors"=>"not found"],404)
            );
        }

         $address = $contact->address()->create($data);
        $response = new AddressResource($address);
        return $response->response()->setStatusCode(201);
    }

    public function get($idcontact,$idaddress)
    {
        $user = Auth::user();
        // Log::info(json_encode($user->id));
        $contact = ContactApi::where("user_id",$user->id)->where("id",$idcontact)->first();
        if(!$contact)
        {
            throw new HttpResponseException(
                response()->json(["errors"=>"not found"],404)
            );
        }
        $address = AddressApi::where("contact_id",$idcontact)->where("id",$idaddress)->first();
        if(!$address)
        {
            throw new HttpResponseException(
                response()->json(["errors"=>"not found"],404)
            );
        }
       return  $response = new AddressResource($address);
        Log::info(json_encode($response));
        return $response->response()->setStatusCode(200);
    }
}
