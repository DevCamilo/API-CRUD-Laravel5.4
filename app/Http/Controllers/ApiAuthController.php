<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Response;
use Illuminate\Http\Request;
use JWTAuth;

class ApiAuthController extends Controller
{


    public function UserAuth(Request $request)
    {
        //$data = $request->all();
        $credentials =  $request->only('user_nickName', 'user_password');
        $token = null;
        try{
            if (!$token = JWTAuth::attempt($credentials)){
                return response()->json(['error' => 'Invalid credential', 'token' => $credentials]);
            }
        }catch(JWTException $ex){
            return response()->json(['error' => 'Something bad'], 500);
        }
        return responde()->json(compact('token'));
    }
}
