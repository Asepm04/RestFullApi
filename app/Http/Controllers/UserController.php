<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\RegisterUserRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Models\User;
use App\Http\Resources\UserRegisterResource;

class UserController extends Controller
{
    public function registerUser(RegisterUserRequest $request)
    {
        $data = $request->validated();

        if(User::where("email",$data["email"])->count()==1)
        {
            throw new HttpResponseException(response()->json([
                "errors"=>[
                    "message"=>"email is already"
                ]
            ]),400);
        }


        $user = User::create($data);
        $user->password = bcrypt($data["password"]);
        $user->save();

        $response=  new UserRegisterResource($user);
        return $response->response()->setStatusCode(200);
    }
}
