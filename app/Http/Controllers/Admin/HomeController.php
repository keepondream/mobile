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

class HomeController extends Controller
{
    /**
     * 后台首页
     */
    public function index()
    {
        //查询导航栏菜单
        $data['count'] = Menu::count();
        $data['category'] = Common::tree();
        return view('admin/index',$data);
    }

    /**
     * 子首页 我的桌面
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function welcome()
    {
        return view('admin/welcome');
    }

    /**
     * 验证权限功能
     * @param Request $request
     */
    public function checkAuth(Request $request)
    {
        $param = Common::dataCheck($request->input());
        $msg = Common::jsonOutData(201,'你暂无此操作权限,请联系管理员!~');

        if (!empty($param['field']) && Common::actionAuth($param['field'])) {
            $msg = Common::jsonOutData(200,'ok');
        }
        return response()->json($msg);
    }

    /**
     * 初始化数据
     */
    public function assist(Request $request)
    {
        $outData = [];
        //填充后台超级管理员
        if (empty(AdminUser::all()->toArray())) {
            $res['name'] = '范乐观';//管理员名称
            $res['password'] = md5(md5('pk'.'fanleguan'));//管理员密码
            $res['role_id'] = 1;
            if (AdminUser::create($res)) {
                $outData[] = '管理员初始化成功!~';
            } else {
                $outData[] = '管理员初始化失败!~';
            }
        } else {
            $outData[] = '管理员表有数据不能初始化!~';
        }
        //填充菜单
        if (empty(Menu::all()->toArray())) {
            $res = [];
            $res[] = [
                'name' => '系统管理',
                'url' => 'systemIndex',
                'icon' => '&#xe62e;',
                'parent_id' => '0',
                'list' => [
                    ['name'=>'系统设置','url'=>'set'],
                    ['name'=>'栏目管理','url'=>'menu'],
                ],
            ];
            $res[] = [
                'name' => '管理员管理',
                'url' => 'managerIndex',
                'icon' => '&#xe62d;',
                'parent_id' => '0',
                'list' => [
                 ['name'=>'权限管理','url'=>'access'],
                 ['name'=>'角色管理','url'=>'role'],
                 ['name'=>'管理员列表','url'=>'manager'],
                ],
            ];
            $res[] = [
                'name' => '会员管理',
                'url' => 'menberIndex',
                'icon' => '&#xe60d;',
                'parent_id' => '0',
                'list' => [
                    ['name'=>'会员列表','url'=>''],
                    ['name'=>'删除的会员','url'=>''],
                    ['name'=>'等级管理','url'=>''],
                    ['name'=>'积分管理','url'=>''],
                ],
            ];
            $res[] = [
                'name' => '产品管理',
                'url' => 'productIndex',
                'icon' => '&#xe620;',
                'parent_id' => '0',
                'list' => [
                    ['name'=>'品牌管理','url'=>''],
                    ['name'=>'分类管理','url'=>''],
                    ['name'=>'产品列表','url'=>''],
                ],
            ];
            $res[] = [
                'name' => '订单管理',
                'url' => 'orderIndex',
                'icon' => '&#xe616;',
                'parent_id' => '0',
                'list' => [
                    ['name'=>'订单列表','url'=>''],
                    ['name'=>'未支付订单','url'=>''],
                ],
            ];
            $res[] = [
                'name' => '日志管理',
                'url' => 'logIndex',
                'icon' => '&#xe61a;',
                'parent_id' => '0',
                'list' => [
                    ['name'=>'会员登录日志','url'=>''],
                    ['name'=>'会员操作记录','url'=>''],
                ],
            ];

            foreach ($res as $k => $data) {
                $tempArr = $data['list'];
                unset($data['list']);
                $data['sort'] = (string)(51 + $k);
                $id = Menu::create($data)->id;
                if ($id > 0) {
                    if (count($tempArr) > 0) {
                        $outData[] = $data['name'].' - 初始化成功!~';
                        foreach ($tempArr as $k1 => $v) {
                            $v['parent_id'] = $id;
                            $v['sort'] = (string)(101 + $k1);
                            if (Menu::create($v)) {
                                $outData[] = $v['name'].' - 初始化成功!~';
                            } else {
                                $outData[] = $v['name'].' --------------初始化----失败!~';
                            }
                        }
                    }
                } else {
                    $outData[] = $data['name'].' --------------初始化----失败!~';
                }
            }
        } else {
            $outData[] = '菜单表有数据不能初始化!~';
        }
        //初始化权限
        if (empty(Access::all()->toArray())) {
            $res = array_merge(Common::menuAuth(),Common::actionAuth());


            foreach ($res as $k => $v) {
                if (Access::create($v)) {
                    $outData[] = $v['title'].' - 初始化成功!~';
                } else {
                    $outData[] = $v['title'].' --------------初始化----失败!~';
                }
            }
        } else {
            $outData[] = '权限表有数据不能初始化!~';
        }
        //初始化角色
        if (empty(Role::all()->toArray())) {
            $res = [
                [
                    'name' => '超级管理员',
                    'desc' => '拥有至高无上的权限',
                    'accesses' => [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26]
                ],
                [
                    'name' => '总管理员',
                    'desc' => '拥有一人之下万人之上的权限',
                    'accesses' => [7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26],
                ],
                [
                    'name' => '普通管理员',
                    'desc' => '拥有会员,产品,订单,日志所有功能权限',
                    'accesses' => [17,18,19,20,21,22,23,24,25,26]
                ]
            ];
            foreach ($res as $role) {
                $id = Role::create($role)->id;
                foreach ($role['accesses'] as $accessid) {
                    RoleAccess::create(['role_id'=>$id,'access_id'=>$accessid]);
                }
                $outData[] = '角色 -- '.$role['name'].' -- 初始化成功!';
            }

        } else {
            $outData[] = '角色表有数据不能初始化!~';
        }
        return response()->json(Common::jsonOutData(200,'ok',$outData));
    }
}
