<?php

namespace App\Http\Controllers\Api\v1;

use Auth;
use JWTAuth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class JwtController extends Controller
{
    // 登录api接口
    public function login(Request $request)
    {
    	$data = $request->only(['email','password']);
    	
    	if($token = Auth::guard('jwt_api')->attempt($data)){
            return $this->setStatusCode(201)->success($token);
    	}

            return $this->failed('账号或者密码错误',400);


    	// if($token = JWTAuth::fromUser($data)){
    	// 	return response()->json(['result' => $token ]);
    	// }else{
    	// 	return response()->json(['result' => false]);
    	// }

    	// echo 1;
    }

    // 退出api接口
    public function logout()
    {
        Auth::guard('jwt_api')->logout();
        return $this->setSstatusCode(201)->success('退出成功');
    }

    //返回当前登录用户信息
    public function getuser()
    {
        $user = Auth::guard('jwt_api')->user();
        return $this->success($user);
        // return JWTAuth::fromUser(config('jwt.user'));
    	// return JWTAuth::parseToken()->authenticate();
    }
}
