<?php

namespace App\Http\Controllers\Admin;

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
}
