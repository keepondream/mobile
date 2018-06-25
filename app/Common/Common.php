<?php
/**
 * Created by PhpStorm.
 * User: dream
 * Date: 2018/6/17
 * Time: 下午12:47
 */

namespace App\Common;


use App\http\Model\Menu;
use App\http\Model\RoleAccess;
use Illuminate\Http\Request;

class Common
{
    /**
     * 系统导航菜单权限
     */
    public static function menuAuth($menuUrl=null)
    {
        //所有菜单权限
        $menuAuthArr = [
            ['title'=>'系统管理','url'=>'systemIndex'],     //系统管理
            ['title'=>'管理员管理','url'=>'managerIndex'],    //管理员管理
            ['title'=>'会员管理','url'=>'menberIndex'],     //会员管理
            ['title'=>'产品管理','url'=>'productIndex'],    //产品管理
            ['title'=>'订单管理','url'=>'orderIndex'],      //订单管理
            ['title'=>'日志管理','url'=>'logIndex'],        //日志管理
        ];
        if (!empty($menuUrl)) {
            //获取当前用户的所有权限
            $access = RoleAccess::where('role_id',session('user')['role_id'])->get();
            $status = false;
            foreach ($access as $accesses) {
                if ($accesses->hasOneAction->url == $menuUrl) {
                    $status = true;
                    break;
                }
            }
            return $status;
        }
        return $menuAuthArr;
    }

    /**
     * 系统操作权限
     */
    public static function actionAuth($actionUrl=null)
    {
        //所有操作权限
        $actionAuthArr = [
            # 系统
            ['title' => '系统设置','url' => 'set'],
            ['title' => '菜单栏管理','url' => 'menu'],
            ['title' => '菜单栏添加','url' => 'menuAdd'],
            ['title' => '菜单栏删除','url' => 'menuDel'],
            # 管理员
            ['title' => '管理员列表','url' => 'manager'],
            ['title' => '添加管理员','url' => 'managerAdd'],
            ['title' => '删除管理员','url' => 'managerDel'],
            ['title' => '审核管理员','url' => 'managerAudit'],
            ['title' => '角色管理','url' => 'role'],
            ['title' => '添加角色','url' => 'roleAdd'],
            ['title' => '删除角色','url' => 'roleDel'],
            ['title' => '权限管理','url' => 'access'],
            ['title' => '添加权限','url' => 'accessAdd'],
            ['title' => '删除权限','url' => 'accessDel'],
            # 会员
            ['title' => '会员列表','url' => 'member'],
            ['title' => '添加会员','url' => 'memberAdd'],
            ['title' => '删除会员','url' => 'memberDel'],
            ['title' => '审核会员','url' => 'memberAudit'],
            ['title' => '已删会员列表','url' => 'delMember'],
            ['title' => '永久清除会员','url' => 'delMemberClean'],
            ['title' => '找回已删会员','url' => 'delMemberBack'],
            ['title' => '等级管理','url' => 'rank'],
            ['title' => '等级操作','url' => 'rankAction'],
            ['title' => '积分管理','url' => 'creditCheck'],
            ['title' => '积分操作','url' => 'rankAction'],
        ];
        if (!empty($actionUrl)) {
            //获取当前用户的所有权限
            $access = RoleAccess::where('role_id',session('user')['role_id'])->get();
            $status = false;
            foreach ($access as $accesses) {
                if ($accesses->hasOneAction->url == $actionUrl) {
                    $status = true;
                    break;
                }
            }
            return $status;
        }
        return $actionAuthArr;
    }

    /**
     * 表单提交非法字符过滤处理
     * @param $array
     * @return array|mixed|string
     */
    public static function dataCheck($array,$status = true)
    {
        if (!empty($array)) {
            if (!get_magic_quotes_gpc()) {
                if (is_array($array)) {
                    foreach ($array as $key => $val) {
                        $array[$key] = self::dataCheck($val);
                    }
                } else {
                    $array = addslashes($array);
                }
                $array = str_replace("&#x", "& # x", $array); //过滤一些不安全字符s
                $array = str_replace("<", "&lt;", $array); //过滤<
            }
            if ($status) {
                if (isset($array['_token'])) {
                    unset($array['_token']);
                }
            }
        }
        return $array;
    }

    /**
     * 组装json返出数据
     * @param $code
     * @param $msg
     * @param null $data
     */
    public static function jsonOutData($code=201,$msg="操作失败!~",$data=null)
    {
        return [
            'code'=>$code,
            'msg'=>$msg,
            'data'=>$data
        ];
    }

    /**
     * 无限极分类 选择框用
     * @param int $parentId
     * @return array
     */
    public static function tree($parentId = 0)
    {
        $rows = Menu::where('parent_id', $parentId)->orderBy('sort','asc')->get()->toArray();
        $arr = array();

        if (sizeof($rows) != 0){
            foreach ($rows as $key => $val){
                $val['list'] = self::tree($val['id']);
                $arr[] = $val;
            }
            return $arr;
        }
    }

    /**
     * 视图用树形数据
     * @param $data
     * @param int $pid
     * @param int $count
     * @return array
     */
    public static function getTree($data, $pid = 0, $count = 0)
    {
        //因为函数再每次调用时都会将之前的数据清空,所以要声明一个静态变量
        static $res = [];
        //对原数组进行遍历,一次去除每一个分类的记录
        foreach ($data as $v) {
            //保存一个计数
            if ($v['parent_id'] == $pid) {
                $v['count'] = $count;
                //将汉字类信息保存在新的数组里面
                $res[] = $v;
                //在继续执行,需要传递处理分类的数组,遍历的时候记录ID
                self::getTree($data,$v['id'],$count + 1);
            }
        }
        return $res;
    }

    /**
     * 所有列表统一调用
     * @return int  默认显示10条数据
     */
    public static function pageSize()
    {
        return 10;
    }


}
