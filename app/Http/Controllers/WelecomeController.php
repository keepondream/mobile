<?php

namespace App\Http\Controllers;

use App\Common\Common;
use App\Libraries\GeeTestSdk\GeetestLib;
use App\User;
use Illuminate\Http\Request;


class WelecomeController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 全站首页
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
//        Common::recordAdminUserLog('2','张三','首页','登陆首页');
//        exit;
//        Auth::logout();
//        var_dump(Auth::check());
//        dd(Auth::user());
//        Common::recordAdminUserLog('2','张三','首页','登陆首页');
        $data['categorys'] = $this->category;
        $data['siteinfo'] = $this->siteinfo;
        return view('welcome',$data);
    }

    /**
     * 未经登录手动指定URL 则跳转首页启动登录页
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function jump(Request $request)
    {
        $data['categorys'] = $this->category;
        $data['siteinfo'] = $this->siteinfo;
        $data['jump'] = 1;
        return view('welcome', $data);
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


    public function geetestCheckOnly(Request $request)
    {
        $Gt = new GeetestLib(env('GEETEST_ID'),env('GEETEST_KEY'));
        $user_id = "test";
        $status = $Gt->pre_process($user_id);
        echo $Gt->get_response_str();
    }
}
