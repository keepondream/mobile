<?php

namespace App\Http\Controllers\Admin;

use App\Common\Common;
use App\Common\ImageUpload;
use App\http\Model\Region;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class MemberController extends Controller
{
    /**
     * 会员列表
     */
    public function member(Request $request)
    {
        $param = Common::dataCheck($request->input());
        if ($request->isMethod('post')) {
            //打印sql的方法
//            DB::enableQueryLog();
            $data['members'] = User::where(function ($query) use ($param) {
                $query->where('name','like',"%{$param['name']}%")
                    ->orWhere('email',$param['name'])
                    ->orWhere('mobile',$param['name']);
            })->where(function ($query) use ($param){
                $query->where('created_at','>',$param['datemin'])
                    ->where('created_at','<',$param['datemax']);
            })->get();
//            return response()->json(DB::getQueryLog());
        } else {
            //获取所有的用户
            $data['members'] = User::all();
        }
        return view('admin/member',$data);

    }

    /**
     * 添加会员
     * @param Request $request
     */
    public function memberAdd(Request $request,ImageUpload $upload)
    {

        $param = Common::dataCheck($request->input());
        $data = [];
        if (!empty($param['id'])) {
            $data['user'] = User::find($param['id']);
        }

        if ($request->isMethod('post')) {
            if (!empty($data['user'])) {
                //更新
                $msg = Common::jsonOutData(201,'修改失败!~');
                //验证用户名称是否重复
                $oldUser = User::where('name',$param['name'])->get();
                if (!empty($oldUser[0]->id) && ($oldUser[0]->id != $param['id'])) {
                    $msg = Common::jsonOutData(201,'用户名已经存在!~');
                } else {
                    //验证密码是否修改
                    if (!empty($param['password'])) {
                        $param['password'] = Hash::make($param['password']);
                    } else {
                        unset($param['password']);
                    }
                    //判断是否有更换头像
                    if ($request->avatar) {
                        $oldAvatar = $data['user']->avatar;
                        $result = $upload->save($request->avatar,'avatar','avatar');
                        if ($result) {
                            $param['avatar'] = $result['path'];
                            //删除旧图片释放资源
                            if (!empty($oldAvatar)) {
                                @unlink(public_path().$oldAvatar);
                            }
                        }
                    }
                    if ($data['user']->update($param)) {
                        $msg = Common::jsonOutData(200,'修改成功!');
                    }
                }
            } else {
                //新增
                $msg = Common::jsonOutData(201,'添加失败!~');
                //验证用户名是否存在
                $oldUser = User::where('name',$param['name'])->get();
                if (!empty($oldUser[0]->id)) {
                    $msg = Common::jsonOutData(201,'用户名已经存在!~');
                } else {
                    //验证密码是否修改
                    if (!empty($param['password'])) {
                        $param['password'] = Hash::make($param['password']);
                    } else {
                        unset($param['password']);
                    }
                    //判断是否有更换头像
                    if ($request->avatar) {
                        $result = $upload->save($request->avatar,'avatar','avatar');
                        if ($result) {
                            $param['avatar'] = $result['path'];
                        }
                    }
                    if (User::create($param)) {
                        $msg = Common::jsonOutData(200,'添加成功!');
                    }
                }
            }
            return response()->json($msg);
        }
        return view('admin/member_add',$data);
    }

    /**
     * 选择城市 jquery 动态获取
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

    /**
     * 修改会员的启停状态
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function memberStatus(Request $request)
    {
        $param = Common::dataCheck($request->input());
        $msg = Common::jsonOutData(201,'非法请求!~');
        if (!empty($param['id'])) {
            $user = User::find($param['id']);
            if (!empty($user)) {
                $user->status = $param['status'];
                if ($user->save()) {
                    $msg = Common::jsonOutData(200,'修改成功!');
                }
            }
        }
        return response()->json($msg);
    }

    /**
     * 修改会员密码
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function changePassword(Request $request)
    {
        $msg = Common::jsonOutData(201,'修改失败!~');
        $param = Common::dataCheck($request->input());
        $data = [];
        if (!empty($param['id'])) {
            $data['user'] = User::find($param['id']);
        }
        if ($request->isMethod('post')) {
            if (!empty($data['user']) && !empty($param['password2'])) {
                $data['user']->password = Hash::make($param['password2']);
                if ($data['user']->save()) {
                    $msg = Common::jsonOutData(200,'修改成功!~');
                }
            }
            return response()->json($msg);
        }
        return view('admin/member_change_password',$data);
    }

    public function memberDel(Request $request)
    {
        $param = Common::dataCheck($request->input());
        $msg = Common::jsonOutData(201,'非法请求!~');
        if (!empty($param['id'])) {
            User::destroy($param['id']);
            $msg = Common::jsonOutData(200,'删除成功!~');
        }
        if (!empty($param['ids'])) {
            User::destroy($param['ids']);
            $msg = Common::jsonOutData(200,'删除成功!~');
        }
        return response()->json($msg);
    }

}
