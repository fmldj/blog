<?php

namespace App\Http\Controllers;

use App\User;
use App\Dynamic;
use Illuminate\Http\Request;
use App\Http\Requests\PasswordRequest;

class UserController extends BaseController
{
	// 更换头像视图展示
    public function avatar()
    {
    	$avatar = authUser()->avatar;
    	return view('user.avatar', compact('avatar'));
    }

    // 更换头像
    public function changeAvatar(Request $request){

    	$user = authUser();
    	$file = $request->file('file');
    	$filename = md5(time().$user->id).'.'.$file->getClientOriginalExtension();
    	$file->move(public_path('images/avatar'), $filename);

    	$user->avatar = '/images/avatar/'.$filename;
    	$user->save();
    	return ['src' => $user->avatar];
    }

    // 修改密码视图展示
    public function password(Request $request)
    {

    	return view('user.password');
    }


    // 修改密码
    public function changePassword(PasswordRequest $request)
    {
    	$user = authUser();
    	$res = password_verify($request->get('old_password'),$user->password);
    	if(!$res){
    		flash('原始密码有误')->error()->important();
    	}

    	$user->password = bcrypt($request->get('password'));
    	$user->save();
    	flash('密码修改成功')->success()->important();
    	return back();
    }


    // 个人设置展示
    public function setting()
    {	
    	$setting = authUser()->settings;
    	return view('user.setting', compact('setting'));
    }


    // 更改设置
    public function changeSetting(Request $request)
    {
        $user = authUser();
    	$user->settings = $request->only(['city','bio','gender','hy','company','position','self']);//限制提交的字段，防止用户自行增加字段
    	$user->save();
    	return back();
    }

    // 用户主页
    public function index(User $user)
    {
        $dynamics = Dynamic::where('user_id',authId())->orderBy('created_at','DESC')->get();
        // dd($dynamics[52]->question);
        return view('user.index',compact('user','dynamics'));
    }



    // 更改用户封面背景图片
    public function changeCover(Request $request)
    {
            $user = authUser();
            $file = $request->file('file');
            $filename = md5(time().$user->id.'_cover').'.'.$file->getClientOriginalExtension();
            $file->move(public_path('images/cover'),$filename);
            $user->bg = '/images/cover/'.$filename;
            $user->save();
            return ['src' => $user->bg];

    }


}
