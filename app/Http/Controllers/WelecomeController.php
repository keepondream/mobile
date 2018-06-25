<?php

namespace App\Http\Controllers;

use App\Common\Common;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WelecomeController extends Controller
{
    //首页
    public function index(Request $request)
    {
//        Common::recordAdminUserLog('2','张三','首页','登陆首页');
//        exit;
//        Auth::logout();
//        var_dump(Auth::check());
//        dd(Auth::user());
        return view('welcome');
    }

    /**
     * 验证用户是否存在,防止重复
     * @param Request $request
     */
    public function checkMember(Request $request)
    {
        $param = Common::dataCheck($request->input());
        $msg = Common::jsonOutData(201,'fault');
        $user = User::where('name',$param['name'])->get()->toArray();
        if (empty($user)) {
            //不存在
            $msg = Common::jsonOutData(200,'ok');
        }
        return response()->json($msg);
    }
}
