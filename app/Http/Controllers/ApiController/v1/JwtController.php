<?php

namespace App\Http\Controllers\ApiController\v1;

use Auth;
use JWTAuth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class JwtController extends Controller
{
    public function login(Request $request)
    {
    	$data = $request->only(['email','password']);
    	
    	if($token = Auth::guard('jwt_api')->attempt($data)){
    		return response()->json(['result' => $token ]);
    	}else{
    		return response()->json(['result' => false]);
    	}

    	// if($token = JWTAuth::attempt($data)){
    	// 	return response()->json(['result' => $token ]);
    	// }else{
    	// 	return response()->json(['result' => false]);
    	// }

    	// echo 1;
    }


    public function getuser()
    {
    	return JWTAuth::parseToken()->authenticate();
    	// echo 1;
    }
}
