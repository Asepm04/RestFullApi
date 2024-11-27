<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\RegisterUserRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\UpdateRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Models\User;
use App\Http\Resources\UserRegisterResource;
use App\Http\Resources\LoginResource;
use App\Http\Resources\LoginedResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

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
            ],400));
        }


        $user = User::create($data);
        $user->password = bcrypt($data["password"]);
        $user->save();

        $response=  new UserRegisterResource($user);
        return $response->response()->setStatusCode(200);
    }

    public function login(LoginRequest $request)
    {
        $user = $request->validated();

        $email = User::where("email",$user["email"])->first();
        $password = User::where("password",bcrypt($user["password"]));
        //untuk debug jika terjadi error pada request
        // Log::info(json_encode($email));
        // Log::info(json_encode($password));


        if(!$email || !$password)
        {
            throw new HttpResponseException(
                response()->json([
                    "errors"=>"email or password is wrong"
                ],400)
            );
        }

        $auth = Auth::attempt(["email"=>$user["email"],"password"=>$user["password"]]);
        if($auth)
        {
            $email->remember_token = Str::uuid()->toString();
            $email->save();
        }
             $login = new LoginedResource($email);
            return $login->response()->setStatusCode(200);
    }

    public function get(Request $request)
    {
        return new LoginResource(Auth::user());
    }

    public function update(UpdateRequest $request)
    {
        $data = $request->validated();
        $user = Auth::user();

        if(isset($data["name"]))
        {
            $user->name = $data["name"];
        }
        if(isset($data["password"]))
        {
            $user->name = $data["password"];
        }
        $user->save();

        return new LoginResource($user);
    }

    public function logout()
    {
        $user = Auth::user();
        $user->remember_token = null;
        $user->save();
        return response()->json(["data"=>true]);
    }
}
