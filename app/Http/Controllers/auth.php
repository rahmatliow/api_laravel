<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;
use Validator;
use App\User;

class auth extends Controller
{
    /**
     * User Login Authentication
     * POST /api/users/login
     *
     * @param string  $email               User email
     * @param string  $password               User password
     * @return Response
     **/
    public function user_login(Request $request){
        $validator = Validator::make($request->all(),[
            "email" => "required",
            "password" => "required",
        ]);

        if($validator->fails()){
            return response()->json(["errors" => $validator->errors()->all()], 422);
        }else{
            $email = $request->input('email');
            $password = $request->input('password');

            $user = User::where(array("email"=>$email))->first();

            if($user == null){
                return response()->json([
                    "status" => "error",
                    "message" => "The email that you've entered doesn't match any account."
                ], 403);
            } else {
                if(!password_verify($password, $user->password)){
                    return response()->json([
                        "status" => "error",
                        "message" => "The email and password you entered don't match."
                    ], 403);
                } else {
                    $token_string = md5(time().$user->name.$user->email.md5($request->header('User-Agent')));

                    if($user->api_token == null || $user->api_token == ""){
                        $user->api_token = $token_string;
                        $user->token_expired = date('Y-m-d H:i:s', strtotime('+5 hour', time()));
                        $user->save();
                    }else{
                        if((strtotime($user->token_expired) - time()) <= 0) {
                            $user->update([
                                "api_token" => $token_string,
                                "token_expired" => date('Y-m-d H:i:s', strtotime('+5 hour', time()))
                            ]);
                        }
                    }

                    return response()->json([
                        "status" => "success",
                        "message" => "Login Success",
                        "api_token" => $user->api_token,
                        "token_expired" => strtotime($user->token_expired),
                        "user" => [
                            "id" => $user->id,
                            "name" => $user->name,
                            "email" => $user->email,
                        ]
                    ], 200);
                }
            }
        }
    }

    /**
     * User Logout
     * POST /api/users/logout
     *
     * @param integer  $email               Id User
     * @return Response
     **/
    public function user_logout(Request $request){
        $id = $request->input("id");
        $user = User::find($id);
        $log = "";
        if($user!=null){
            $log = $user->update([
                    "api_token" => '',
                    "token_expired" => ''
                ]);
        }

        if($log){
            return response()->json([
                "status" => "success",
                "message" => "Log Out Success",
            ], 200);
        }else{
            return response()->json([
                "status" => "error",
                "message" => "log out failed!"
            ],403);
        }
    }
}
