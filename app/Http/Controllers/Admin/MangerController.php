<?php

namespace App\Http\Controllers\Admin;

use App\Common\Common;
use App\http\Model\Access;
use App\http\Model\AdminUser;
use App\http\Model\Menu;
use App\http\Model\Role;
use App\http\Model\RoleAccess;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MangerController extends Controller
{
    //管理员管理
    /**
     * 角色管理
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function role(Request $request)
    {
        //获取系统所有角色
        $roles = Role::all();
        $data['roles'] = $roles;
        return view('admin/role', $data);
    }

    /**
     * 添加/修改角色
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function roleAdd(Request $request)
    {
        //获取所有权限 便于添加角色时进行权限划分
        $data['accesses'] = Access::all()->toArray();
        $param = Common::dataCheck($request->input());
        if (!empty($param['id'])) {
            //根据角色 获取角色相关的用户
            $role = Role::find($param['id']);
            if (!empty($role)) {
                $data['data'] = $role->toArray();
                $accessids = RoleAccess::where('role_id', $param['id'])->get(['access_id'])->toArray();
                $data['accessids'] = array_column($accessids, 'access_id');
            }
        }

        //如果是post提交判断是否存在ID且不为空 有则更新无则新增
        if ($request->isMethod('post')) {
            //验证角色名称是否重复
            $unique = Role::where('name', $param['name'])->get()->toArray();
            if (!empty($unique) && empty($param['id'])) {
                $msg = Common::jsonOutData(201, '角色名称不能重复!~');
            } else {
                if (!empty($role)) {
                    //修改
                    $role->name = $param['name'];
                    $role->desc = $param['desc'];
                    if ($role->save()) {
                        if (!empty($param['accessid'])) {
                            //循环比较修改的数据
                            foreach ($param['accessid'] as $v) {
                                if (!empty($data['accessids']) && in_array($v, $data['accessids'])) {
                                    //如果当前的id在原先的数组中 进行比对删除数组 筛选不在其中的
                                    foreach ($data['accessids'] as $k => $vs) {
                                        if ($vs == $v) {
                                            unset($data['accessids'][$k]);
                                            continue;
                                        }
                                    }
                                } else {
                                    //进行新增操作
                                    $tempData = [];
                                    $tempData['role_id'] = $param['id'];
                                    $tempData['access_id'] = $v;
                                    RoleAccess::create($tempData);
                                }
                            }
                        }
                        //如果还有旧的值 则进行旧数据删除
                        if (!empty($data['accessids'])) {
                            foreach ($data['accessids'] as $accessid) {
                                RoleAccess::where(['role_id' => $param['id'], 'access_id' => $accessid])->delete();
                            }
                        }
                        $msg = Common::jsonOutData(200, '编辑成功!');
                    }
                } else {
                    //新增
                    unset($param['id']);
                    $accessid = $param['accessid'];
                    unset($param['accessid']);
                    $newRoleId = Role::create($param)->id;
                    if (count($accessid) > 0) {
                        foreach ($accessid as $v) {
                            $tempData = [];
                            $tempData['role_id'] = $newRoleId;
                            $tempData['access_id'] = $v;
                            RoleAccess::create($tempData);
                        }
                    }
                    $msg = Common::jsonOutData(200, '添加成功!');
                }
            }

            return response()->json($msg);
        }


        return view('admin/role_add', $data);
    }

    /**
     * 删除角色
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function roleDel(Request $request)
    {
        $param = Common::dataCheck($request->input());
        $msg = Common::jsonOutData(201, '删除失败!~');
        if (!empty($request->isMethod('post'))) {
            if (!empty($param['id'])) {
                //先删除角色对应的权限 再删除此权限
                RoleAccess::where('role_id', $param['id'])->delete();
                Role::destroy($param['id']);
            } elseif (!empty($param['ids'])) {
                foreach ($param['ids'] as $id) {
                    RoleAccess::where('role_id', $id)->delete();
                    Role::destroy($id);
                }
            }
            $msg = Common::jsonOutData(200, '删除成功!');
        }
        return response()->json($msg);
    }

    /**
     * 权限管理
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function access(Request $request)
    {
        $param = Common::dataCheck($request->input());
        //获取相关数据
        $data['count'] = Access::count();
        $data['data'] = Access::all()->toArray();

        //判断是否有搜索
        if (!empty($param) && isset($param['searchData']) && $request->isMethod('post')) {
            $idOrname = $param['searchData'];
            if (!empty($idOrname)) {
                $res = Access::where(function ($query) use ($idOrname) {
                    $query->where('id', $idOrname)
                        ->orWhere('title', 'like', '%' . $idOrname . '%');
                })->get();
                if (count($res) > 0) {
                    $data['data'] = $res->toArray();
                }
            }
        }
        return view('admin/access', $data);
    }

    /**
     * 添加/修改权限
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function accessAdd(Request $request)
    {
        $param = Common::dataCheck($request->input());
        $data['data'] = '';
        if (!empty($param['id'])) {
            $access = Access::find($param['id']);
            if (!empty($access)) {
                $data['data'] = $access->toArray();
            }
        }
        //如果是post提交判断是否存在ID且不为空 有则更新无则新增
        if ($request->isMethod('post')) {
            if (!empty($access)) {
                //修改
                $access->title = $param['title'];
                $access->url = $param['url'];
                $msg = Common::jsonOutData(201, '编辑失败!~');
                if ($access->save()) {
                    $msg = Common::jsonOutData(200, '编辑成功!');
                }
            } else {
                //新增
                unset($param['id']);
                $res = Access::create($param);
                $msg = Common::jsonOutData(201, '添加失败!~');
                if ($res) {
                    $msg = Common::jsonOutData(200, '添加成功!');
                }
            }
            return response()->json($msg);
        }
        return view('admin/access_add', $data);
    }

    /**
     * 删除权限
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function accessDel(Request $request)
    {
        $param = Common::dataCheck($request->input());
        $msg = Common::jsonOutData(201, '删除失败!~');
        if (!empty($request->isMethod('post'))) {
            if (!empty($param['id'])) {
                //先删除角色权限表中的当前权限 再删除当前权限
                RoleAccess::where('access_id', $param['id'])->delete();
                Access::destroy($param['id']);
            } elseif (!empty($param['ids'])) {
                foreach ($param['ids'] as $accessid) {
                    RoleAccess::where('access_id', $accessid)->delete();
                    Access::destroy($accessid);
                }
            }
            $msg = Common::jsonOutData(200, '删除成功!');
        }
        return response()->json($msg);
    }

    /**
     * 管理员管理
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function manager(Request $request)
    {
        $param = Common::dataCheck($request->input());
        if ($request->isMethod('post') && !empty($param['name'])) {
            $data['adminUsers'] = AdminUser::where('name', 'like', "%{$param['name']}%")->where(function ($query) use ($param) {
                $query->where('created_at', '>', $param['datemin'])
                    ->where('created_at', '<', $param['datemax']);
            })->get();
        } else {
            //获取所有管理员
            $data['adminUsers'] = AdminUser::all();
        }
        return view('admin/manager', $data);
    }

    /**
     * 添加/修改管理员
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function managerAdd(Request $request)
    {
        $param = Common::dataCheck($request->input());
        //获取当前系统的所有角色
        $data['roles'] = Role::all()->toArray();
        if (!empty($param['id'])) {
            $data['adminUser'] = AdminUser::find($param['id']);
        }
        array_unshift($data['roles'], ['id' => '', 'name' => '--请选择--']);

        if ($request->isMethod('post')) {
            if (!empty($data['adminUser'])) {
                //更新
                $msg = Common::jsonOutData(201, '修改失败!~');
                //验证用户名是否存在 且不是自己
                $oldAdminUser = AdminUser::where('name', $param['name'])->get();
                if (!empty($oldAdminUser[0]->id) && ($oldAdminUser[0]->id != $data['adminUser']->id)) {
                    $msg = Common::jsonOutData(201, '此用户名已经存在!~');
                } else {
                    //验证是否修改密码
                    if (empty($param['password']) || empty($param['password2'])) {
                        unset($param['password']);
                        unset($param['password2']);
                    } else {
                        $data['adminUser']->password = md5(md5('pk' . $param['password2']));
                    }
                    $data['adminUser']->name = $param['name'];
                    $data['adminUser']->sex = $param['sex'];
                    $data['adminUser']->mobile = $param['mobile'];
                    $data['adminUser']->email = $param['email'];
                    $data['adminUser']->role_id = $param['role_id'];
                    $data['adminUser']->desc = $param['desc'];
                    if ($data['adminUser']->save()) {
                        $msg = Common::jsonOutData(200, '修改成功!');
                    }
                }
            } else {
                //新增
                $msg = Common::jsonOutData(201, '添加失败!~');
                //验证用户名是否存在
                if (!empty(AdminUser::where('name', $param['name'])->get()->toArray())) {
                    $msg = Common::jsonOutData(201, '此用户名已经存在!~');
                } else {
                    $param['password'] = md5(md5('pk' . $param['password2']));
                    if (AdminUser::create($param)) {
                        $msg = Common::jsonOutData(200, '添加成功!');
                    }
                }
            }

            return response()->json($msg);
        }
        return view('admin/manager_add', $data);
    }

    /**
     * 删除管理员
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function managerDel(Request $request)
    {
        $param = Common::dataCheck($request->input());
        $msg = Common::jsonOutData(201, '非法请求!~');
        if (!empty($param['id'])) {
            AdminUser::destroy($param['id']);
            $msg = Common::jsonOutData(200, '删除成功!');
        }
        if (!empty($param['ids'])) {
            AdminUser::destroy($param['ids']);
            $msg = Common::jsonOutData(200, '删除成功!');
        }
        return response()->json($msg);
    }

    /**
     * 修改管理员启用状态
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function managerStatus(Request $request)
    {
        $param = Common::dataCheck($request->input());
        $msg = Common::jsonOutData(201, '非法请求!~');
        if (!empty($param['id'])) {
            $adminUser = AdminUser::find($param['id']);
            $adminUser->status = !empty($param['status']) ? $param['status'] : '0';
            $adminUser->save();
            $msg = Common::jsonOutData(200, '更新成功!');
        }
        return response()->json($msg);
    }

}


