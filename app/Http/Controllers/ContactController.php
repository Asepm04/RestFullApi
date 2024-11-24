<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ContactApi;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\ContactResource;
use App\Http\Requests\ContactRequest;
use App\Http\Requests\UpdateContactRequest;

class ContactController extends Controller
{
    public function create(ContactRequest $request)
    {
        $data = $request->validated();
        $user = Auth::user();

        if($data && $user)
        {
          $contact =  $user->contact()->create($data);
        }
        return new ContactResource($contact);
    }

    public function get($id)
    {
        $user = Auth::user();
        $contact = ContactApi::where("id",$id)->where("user_id",$user->id)->first();

        if(!$contact)
        {
           return  response()->json(["errors"=>"not found"],404);
            
        }
            return new ContactResource($contact);
    }

    public function update($id,UpdateContactRequest $request)
    {
        $user = Auth::user();
        $contact = ContactApi::where("id",$id)->where("user_id",$user->id)->first();
        if(!$contact)
        {
          return  throw new HttpResponseException(
                response()->json([
                    "errors"=> "not found"
                ],404)
            );
        }

        $data = $request->validated();
        $contact->fill($data);
        $contact->save();

        return new ContactResource($contact);
    }
}
