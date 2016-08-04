<?php

namespace App\Http\Middleware;

use Closure;
use App\User;

class APIAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if($request->header("X-Auth-Token") == null){
            return response()->json(array("message" => "Please provide X-Auth-Token on your header"), 403);
        } else {
            if($request->header("X-Auth-Token") != ENV("LOCAL_AUTH")){
                $tokens = User::where([
                    "api_token" => $request->header("X-Auth-Token"),
                ])->first();

                if($tokens == null){
                    return response()->json(array(
                        "message" => "Sorry! We can't found any matching user by given token"
                    ), 403);
                } else {
                }
            }
        }

        return $next($request);
    }
}
