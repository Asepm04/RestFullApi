<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\User;

class AuthorizeMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $token = $request->header("authorization");
        $auth = true;

        $data = User::where("remember_token",$token)->first();
        //debug to get $data 
        Log::info(json_encode($token));


        if(!$token)
        {
            $auth = false;
        }
        if(!$data)
        {
            $auth = false;
        }
        else
        {
            Auth::login($data);
        }
        if($auth)
        {
            return $next($request);
        }
        else
        {
            return response()->json(["errors"=>"unauthorize"],400);
        }


        
    }
}
