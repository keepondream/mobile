<?php

namespace App\Http\Controllers\Admin;

use App\Common\Common;
use App\http\Model\Region;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MemberController extends Controller
{
    /**
     * 会员列表
     */
    public function member(Request $request)
    {
        //获取所有的用户
        $data['members'] = User::all();
        return view('admin/member',$data);

    }

    /**
     * 添加会员
     * @param Request $request
     */
    public function memberAdd(Request $request)
    {
        $param = Common::dataCheck($request->input());
        if ($request->isMethod('post')) {

            dd($param);
        }
        return view('admin/member_add');
    }

    /**
     * 选择城市
     * @param Request $request
     */
    public function citySelect(Request $request)
    {
        $param = Common::dataCheck($request->input());
        $parent_id = $param['parent_id'];
        $data= Region::where('parent_id',$parent_id)->select(['code','name'])->get()->toArray();

        $msg = Common::jsonOutData(200,'ok',$data);
        return response()->json($msg);
    }
}
