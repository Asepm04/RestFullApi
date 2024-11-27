<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ContactApi;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\ContactResource;
use App\Http\Resources\ContactColletion;
use App\Http\Requests\ContactRequest;
use App\Http\Requests\UpdateContactRequest;
use Illuminate\Database\Eloquent\Builder;

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

    public function delete($id)
    {
        $user = Auth::user();
        $contact = ContactApi::where("id",$id)->where("user_id",$user->id);

        if(!$contact)
        {
            throw new HttpResponseException(
                response()->json([
                    "errors"=>"not found"
                ],404)
            );
        }

        $contact->delete();
        return response()->json([
            "data"=>true
        ],200);
    }

    public function paginate(Request $request)
    {
        $user = Auth::user();
        $page = $request->input("page",1);
        $size = $request->input("size",1);

        $contact = ContactApi::where('user_id',$user->id);
        // Log::info(json_encode([$contact->get(),$user->id],JSON_PRETTY_PRINT));
        //DEBUG BERHASIL
        // Log::info(json_encode($user->contact()->pluck("id")));
        //pluck() digunakan untuk ambil colom tertentu
        if(!$contact)
        {
            return response()->json(["errors"=>"not found"],404);
        }

        $contact->where(function(Builder $builder) use($request)
    {
        $nama = $request->input("nama");
        if($nama)
        {
            $builder->where(function( Builder $builder) use($nama)
            {
                $builder->orWhere('first_name','like',' %' . $nama .' %');
                $builder->orWhere('last_name','like',' %' . $nama .' %');
            });
        }
    });

    $contacts =  $contact->paginate(perPage: $size, page:$page);
    return new ContactColletion($contacts);


    }
}
