<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\ContactResource;
use App\Http\Requests\ContactRequest;

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
}
