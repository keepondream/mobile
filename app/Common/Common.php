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
     * 记录管理员操作日志
     * @param $adminId      管理员id
     * @param $adminName    管理员名称
     * @param $action       动作类目
     * @param $actionDesc   操作描述
     */
    public static function recordAdminUserLog($adminId,$adminName,$action,$actionDesc)
    {
        $data['admin_user_id'] = $adminId;
        $data['admin_user_name'] = $adminName;
        $data['admin_user_agent'] = '设备';
        $data['admin_user_agent_str'] = '设备类型';
        $data['ip'] = self::getip();
        $data['action'] = $action;
        $data['actiondesc'] = $actionDesc;

        var_dump(self::get_broswer());
        dd($data);
    }


    /**
     * 获取真实IP
     * @return string
     */
    public static function getip()
    {
        static $ip = '';
        $ip = $_SERVER['REMOTE_ADDR'];
        if(isset($_SERVER['HTTP_CDN_SRC_IP'])) {
            $ip = $_SERVER['HTTP_CDN_SRC_IP'];
        } elseif (isset($_SERVER['HTTP_CLIENT_IP']) && preg_match('/^([0-9]{1,3}\.){3}[0-9]{1,3}$/', $_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif(isset($_SERVER['HTTP_X_FORWARDED_FOR']) AND preg_match_all('#\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}#s', $_SERVER['HTTP_X_FORWARDED_FOR'], $matches)) {
            foreach ($matches[0] AS $xip) {
                if (!preg_match('#^(10|172\.16|192\.168)\.#', $xip)) {
                    $ip = $xip;
                    break;
                }
            }
        }
        return $ip;
    }

    //根据ip获取城市、网络运营商等信息
    public function findCityByIp($ip){
        $data = file_get_contents('http://ip.taobao.com/service/getIpInfo.php?ip='.$ip);
        return json_decode($data,$assoc=true);
    }

    //获取用户浏览器类型
    public function getBrowser(){
        $agent=$_SERVER["HTTP_USER_AGENT"];
        if(strpos($agent,'MSIE')!==false || strpos($agent,'rv:11.0')) //ie11判断
            return "ie";
        else if(strpos($agent,'Firefox')!==false)
            return "firefox";
        else if(strpos($agent,'Chrome')!==false)
            return "chrome";
        else if(strpos($agent,'Opera')!==false)
            return 'opera';
        else if((strpos($agent,'Chrome')==false)&&strpos($agent,'Safari')!==false)
            return 'safari';
        else
            return 'unknown';
    }

    //获取网站来源
    public function getFromPage(){
        return $_SERVER['HTTP_REFERER'];
    }

    /**
     * 获取用户设备信息
     * @return string
     */
    public static function get_broswer()
    {
        $sys = $_SERVER['HTTP_USER_AGENT'];  //获取用户代理字符串

        if (stripos($sys, "Firefox/") > 0) {

            preg_match("/Firefox/([^;)]+)+/i", $sys, $b);
            $exp[0] = "Firefox";
            $exp[1] = $b[1];  //获取火狐浏览器的版本号

        } elseif (stripos($sys, "Maxthon") > 0) {

            preg_match("/Maxthon/([d.]+)/", $sys, $aoyou);
            $exp[0] = "傲游";
            $exp[1] = $aoyou[1];

        } elseif (stripos($sys, "Baiduspider") > 0) {

            $exp[0] = "百度";
            $exp[1] = '蜘蛛';

        }elseif (stripos($sys, "YisouSpider") > 0) {

            $exp[0] = "一搜";
            $exp[1] = '蜘蛛';

        }elseif (stripos($sys, "Googlebot") > 0) {

            $exp[0] = "谷歌";
            $exp[1] = '蜘蛛';

        }elseif (stripos($sys, "Android 4.3") > 0) {

            $exp[0] = "安卓";
            $exp[1] = '4.3';

        }
        elseif (stripos($sys, "MSIE") > 0) {

            preg_match("/MSIEs+([^;)]+)+/i", $sys, $ie);
            $exp[0] = "IE";
            $exp[1] = $ie[1];  //获取IE的版本号

        } elseif (stripos($sys, "OPR") > 0) {

            preg_match("/OPR/([d.]+)/", $sys, $opera);
            $exp[0] = "Opera";
            $exp[1] = $opera[1];

        } elseif(stripos($sys, "Edge") > 0) {

            //win10 Edge浏览器 添加了chrome内核标记 在判断Chrome之前匹配
            preg_match("/Edge/([d.]+)/", $sys, $Edge);
            $exp[0] = "Edge";
            $exp[1] = $Edge[1];

        } elseif (stripos($sys, "Chrome") > 0) {

            preg_match("/Chrome/([d.]+)/", $sys, $google);
            $exp[0] = "Chrome";
            $exp[1] = $google[1];  //获取google chrome的版本号

        } elseif(stripos($sys,'rv:')>0 && stripos($sys,'Gecko')>0){

            preg_match("/rv:([d.]+)/", $sys, $IE);
            $exp[0] = "IE";
            $exp[1] = $IE[1];

        }else if(stripos($sys,'AhrefsBot')>0){

            $exp[0] = "AhrefsBot";
            $exp[1] = '蜘蛛';

        }else if(stripos($sys,'Safari')>0){

            preg_match("/([d.]+)/", $sys, $safari);
            $exp[0] = "Safari";
            $exp[1] = $safari[1];

        }else if(stripos($sys,'bingbot')>0){

            $exp[0] = "必应";
            $exp[1] = '蜘蛛';

        }else if(stripos($sys,'WinHttp')>0){

            $exp[0] = "windows";
            $exp[1] = 'WinHttp 请求接口工具';

        }else if(stripos($sys,'iPhone OS 10')>0){

            $exp[0] = "iPhone";
            $exp[1] = 'OS 10';

        }else if(stripos($sys,'Sogou')>0){

            $exp[0] = "搜狗";
            $exp[1] = '蜘蛛';

        }else if(stripos($sys,'HUAWEIM')>0){

            $exp[0] = "华为";
            $exp[1] = '手机端';

        }else if(stripos($sys,'Dalvik')>0){

            $exp[0] = "安卓";
            $exp[1] = 'Dalvik虚拟机';

        }else if(stripos($sys,'Mac OS X 10')>0){

            $exp[0] = "MAC";
            $exp[1] = 'OS X10';

        }else if(stripos($sys,'Opera/9.8')>0){
            $exp[0] = "Opera";
            $exp[1] = '9.8';
        }else if(stripos($sys,'JikeSpider')>0){

            $exp[0] = "即刻";
            $exp[1] = '蜘蛛';

        }else if(stripos($sys,'Baiduspider')>0){

            $exp[0] = "百度";
            $exp[1] = '蜘蛛';

        }
        else {

            $exp[0] = $sys;
            $exp[1] = "";

        }

        return $exp[0].' '.$exp[1];

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
