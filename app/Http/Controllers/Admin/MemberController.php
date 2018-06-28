<?php

namespace App\Http\Controllers\Admin;

use App\Common\Common;
use App\Common\ImageUpload;
use App\http\Model\Region;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

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
