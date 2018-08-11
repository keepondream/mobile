<?php
/**
 * Created by PhpStorm.
 * User: dream
 * Date: 2018/6/17
 * Time: 下午12:47
 */

namespace App\Common;


use App\http\Model\AdminUserLog;
use App\http\Model\Category;
use App\http\Model\Menu;
use App\http\Model\Region;
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
            ['title' => '修改会员密码','url' => 'memberChangePassword'],
            ['title' => '已删会员列表','url' => 'delMember'],
            ['title' => '永久清除会员','url' => 'delMemberClean'],
            ['title' => '找回已删会员','url' => 'delMemberBack'],
            ['title' => '等级管理','url' => 'rank'],
            ['title' => '等级操作','url' => 'rankAction'],
            ['title' => '积分管理','url' => 'creditCheck'],
            ['title' => '积分操作','url' => 'rankAction'],
            # 产品管理
            ['title' => '平台管理','url' => 'paas'],
            ['title' => '添加平台','url' => 'paasAdd'],
            ['title' => '删除平台','url' => 'paasDel'],
            ['title' => '审核平台','url' => 'paasAudit'],
            ['title' => '分类管理','url' => 'category'],
            ['title' => '添加分类','url' => 'categoryAdd'],
            ['title' => '删除分类','url' => 'categoryDel'],
            ['title' => '项目管理','url' => 'project'],
            ['title' => '添加项目','url' => 'projectAdd'],
            ['title' => '删除项目','url' => 'projectDel'],
            ['title' => '审核项目','url' => 'projectAudit'],




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
     * 会员等级和对应图标
     * @param $grade
     * @return array
     */
    public static function grade($grade)
    {
        $arr = [
            '1' => '铜牌会员',
            '2' => '银牌会员',
            '3' => '金牌会员',
            '4' => '铂金会员',
            '5' => '砖石会员',
            '6' => 'VIP会员',
        ];
        $imgArr = [
            '1' => 'static/h-ui/images/tongpai.png',
            '2' => 'static/h-ui/images/yinpai.png',
            '3' => 'static/h-ui/images/jinpai.png',
            '4' => 'static/h-ui/images/bojin.png',
            '5' => 'static/h-ui/images/zhuanshi.png',
            '6' => 'static/h-ui/images/vip.png',
        ];
        return [
            'grade' => $arr[$grade],
            'img' => $imgArr[$grade]
        ];
    }

    /**
     * 验证品牌平台接口是否存在
     * @param $sign
     * @return mixed|string
     */
    public static function checkBrand($sign)
    {
        if (empty($sign)) {
            return '';
        }
        $arr = [
            'yima' => '\App\Libraries\Sms51ym\Sms51ym',
            'maizi' => '\App\Libraries\Smsmaizi\Smsmaizi',
        ];
        if (isset($arr[$sign])) {
            return $arr[$sign];
        }
        return '';
    }

    /**
     * 不同平台的运营商参数
     * @param $sign
     * @return array
     */
    public static function isp($sign)
    {
        $arryima = [
            '0' => '--不限--',
            '1' => '联通',
            '2' => '移动',
            '3' => '电信',
        ];
        $arrmaizi = [
            '0' => '--不限--',
            '1' => '移动',
            '2' => '联通',
            '3' => '电信',
            '4' => '国外',
            '5' => '虚拟号',
            '6' => '非虚拟号',
        ];
        if ($sign == 'yima') {
            return $arryima;
        } else if ($sign == 'maizi') {
            return $arrmaizi;
        } else {
            return null;
        }
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
     * 生成唯一订单号
     * @return string
     */
    public static function orderSn()
    {
        //A 代表2018年 依次类推
        $yCode = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
        return $yCode[intval(date('Y')) - 2018] . strtoupper(dechex(date('m'))) . date('d') . substr(time(), -5) . substr(microtime(), 2, 5) . sprintf('%02d', rand(0, 99));
    }

    /**
     * 无限极分类 选择框用
     * @param int $parentId
     * @return array
     */
    public static function tree($parentId = 0,$status=null)
    {
        if (!empty($status)) {
            $rows = Category::where('parent_id', $parentId)->orderBy('sort','asc')->get()->toArray();
        } else {
            $rows = Menu::where('parent_id', $parentId)->orderBy('sort','asc')->get()->toArray();
        }
        $arr = array();

        if (sizeof($rows) != 0){
            foreach ($rows as $key => $val){
                if (!empty($status)) {
                    $val['list'] = self::tree($val['id'],1);
                } else {
                    $val['list'] = self::tree($val['id']);
                }
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
        $data['action'] = $action;
        $data['actiondesc'] = $actionDesc;
        $res = self::getLoginTail();
        if (!empty($res)) {
            $params = array_merge($data,$res);
        }
        AdminUserLog::create($params);
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


    /**
     * 判断用户是手机访问还是pc访问
     * @return bool
     */
    public static function isMobile()
    {
        $is_mobile = false; //默认不是手机访问
        //1.获取用户浏览器信息 等；
        $user_agent = $_SERVER['HTTP_USER_AGENT'];
        //2.列举常用手机终端类型
        $mobile_agents = array("240x320","acer","acoon","acs-","abacho","ahong","airness","alcatel","amoi",
            "android","anywhereyougo.com","applewebkit/525","applewebkit/532","asus","audio",
            "au-mic","avantogo","becker","benq","bilbo","bird","blackberry","blazer","bleu",
            "cdm-","compal","coolpad","danger","dbtel","dopod","elaine","eric","etouch","fly ",
            "fly_","fly-","go.web","goodaccess","gradiente","grundig","haier","hedy","hitachi",
            "htc","huawei","hutchison","inno","ipad","ipaq","iphone","ipod","jbrowser","kddi",
            "kgt","kwc","lenovo","lg ","lg2","lg3","lg4","lg5","lg7","lg8","lg9","lg-","lge-","lge9","longcos","maemo",
            "mercator","meridian","micromax","midp","mini","mitsu","mmm","mmp","mobi","mot-",
            "moto","nec-","netfront","newgen","nexian","nf-browser","nintendo","nitro","nokia",
            "nook","novarra","obigo","palm","panasonic","pantech","philips","phone","pg-",
            "playstation","pocket","pt-","qc-","qtek","rover","sagem","sama","samu","sanyo",
            "samsung","sch-","scooter","sec-","sendo","sgh-","sharp","siemens","sie-","softbank",
            "sony","spice","sprint","spv","symbian","tablet","talkabout","tcl-","teleca","telit",
            "tianyu","tim-","toshiba","tsm","up.browser","utec","utstar","verykool","virgin",
            "vk-","voda","voxtel","vx","wap","wellco","wig browser","wii","windows ce",
            "wireless","xda","xde","zte");
        foreach ($mobile_agents as $device) {
            if (stristr($user_agent, $device)) {
                //手机访问
                $is_mobile = true;
                break;
            }
        }
        return $is_mobile;
    }

    /**
     * 获取用户登录的详细信息
     */
    public static function getLoginTail()
    {
        $data = [];
        if (self::isMobile()) {
            //获取手机访问信息
            $ioopdnuber = new mobile();
            $data['ip'] = $ioopdnuber->getIP();
            $data['mobile'] = !empty($ioopdnuber->getPhoneNumber()) ? $ioopdnuber->getPhoneNumber() : '';
            $data['admin_user_agent_type'] = $ioopdnuber->get_device_type();
            $data['admin_user_agent_name'] = $ioopdnuber->get_phone_name();
            $data['admin_user_agent_str'] = $ioopdnuber->getUA();
        } else {
            $user_agent = $_SERVER['HTTP_USER_AGENT'];
            //获取pc访问信息
            $data['ip'] = self::getip();
            $data['admin_user_agent_type'] = 'pc';
            $name = self::_getclientoperation_for_userauth($user_agent);
            $data['admin_user_agent_name'] = !empty($name) ? $name : '未识别的系统';
            $browserData = self::_getclientbrowser_for_userauth($user_agent);
            $data['admin_user_agent_str'] = !empty($browserData) ? $browserData : '未识别的浏览器';;
        }
        return $data;
    }


    /**
     * 从 user-agent 通过映射关系获取 操作系统信息
     */
    public static function _getclientoperation_for_userauth($_useragent){
        if(!empty($_useragent)){
            $ua = strtolower($_useragent);

            $operation_map = array(
                'Windows 10' => array(
                    'alias'=>array('Windows NT 6.4', 'Windows NT 10'),
                    'excludes'=>array()
                ),
                'Windows 8.1' => array(
                    'alias'=>array('Windows NT 6.3'),
                    'excludes'=>array()
                ),
                'Windows 8' => array(
                    'alias'=>array('Windows NT 6.2'),
                    'excludes'=>array('Xbox', 'Xbox One')
                ),
                'Windows 7' => array(
                    'alias'=>array('Windows NT 6.1'),
                    'excludes'=>array('Xbox', 'Xbox One')
                ),
                'Windows Vista' => array(
                    'alias'=>array('Windows NT 6'),
                    'excludes'=>array('Xbox', 'Xbox One')
                ),
                'Windows 2000' => array(
                    'alias'=>array('Windows NT 5.0'),
                    'excludes'=>array()
                ),
                'Windows XP' => array(
                    'alias'=>array('Windows NT 5'),
                    'excludes'=>array('ggpht.com')
                ),
                'Windows 10 Mobile' => array(
                    'alias'=>array('Windows Phone 10'),
                    'excludes'=>array()
                ),
                'Windows Phone 8.1' => array(
                    'alias'=>array('Windows Phone 8.1'),
                    'excludes'=>array()
                ),
                'Windows Phone 8' => array(
                    'alias'=>array('Windows Phone 8'),
                    'excludes'=>array()
                ),
                'Windows Phone 7' => array(
                    'alias'=>array('Windows Phone OS 7'),
                    'excludes'=>array()
                ),
                'Windows Mobile' => array(
                    'alias'=>array('Windows CE'),
                    'excludes'=>array()
                ),
                'Windows 98' => array(
                    'alias'=>array('Windows 98', 'Win98'),
                    'excludes'=>array('Palm')
                ),
                'Xbox OS' => array(
                    'alias'=>array('xbox'),
                    'excludes'=>array()
                ),
                'Windows' => array(
                    'alias'=>array('Windows'),
                    'excludes'=>array('Palm', 'ggpht.com')
                ),
                'Android 6.x' => array(
                    'alias'=>array('Android 6', 'Android-6'),
                    'excludes'=>array('glass')
                ),
                'Android 6.x Tablet' => array(
                    'alias'=>array('Android 6', 'Android-6'),
                    'excludes'=>array('mobile', 'glass')
                ),
                'Android 5.x' => array(
                    'alias'=>array('Android 5', 'Android-5'),
                    'excludes'=>array('glass')
                ),
                'Android 5.x Tablet' => array(
                    'alias'=>array('Android 5', 'Android-5'),
                    'excludes'=>array('mobile', 'glass')
                ),
                'Android 4.x' => array(
                    'alias'=>array('Android 4', 'Android-4'),
                    'excludes'=>array('glass', 'ubuntu')
                ),
                'Android 4.x Tablet' => array(
                    'alias'=>array('Android 4', 'Android-4'),
                    'excludes'=>array('mobile', 'glass', 'ubuntu')
                ),
                'Android 4.x' => array(
                    'alias'=>array('Android 4'),
                    'excludes'=>array('ubuntu')
                ),
                'Android 3.x Tablet' => array(
                    'alias'=>array('Android 3'),
                    'excludes'=>array()
                ),
                'Android 2.x' => array(
                    'alias'=>array('Android 2'),
                    'excludes'=>array()
                ),
                'Android 2.x Tablet' => array(
                    'alias'=>array('Kindle Fire', 'GT-P1000', 'SCH-I800'),
                    'excludes'=>array()
                ),
                'Android 1.x' => array(
                    'alias'=>array('Android 1'),
                    'excludes'=>array()
                ),
                'Android Mobile' => array(
                    'alias'=>array('Mobile'),
                    'excludes'=>array('ubuntu')
                ),
                'Android Tablet' => array(
                    'alias'=>array('Tablet'),
                    'excludes'=>array()
                ),
                'Android' => array(
                    'alias'=>array('Android'),
                    'excludes'=>array('Ubuntu')
                ),
                'Chrome OS' => array(
                    'alias'=>array('CrOS'),
                    'excludes'=>array()
                ),
                'WebOS' => array(
                    'alias'=>array('webOS'),
                    'excludes'=>array()
                ),
                'PalmOS'=>array(
                    'alias'=>array('Palm'),
                    'excludes'=>array()
                ),
                'MeeGo' => array(
                    'alias'=>array('MeeGo'),
                    'excludes'=>array()
                ),
                'iOS 9 (iPhone)' => array(
                    'alias'=>array('iPhone OS 9'),
                    'excludes'=>array()
                ),
                'iOS 8.4 (iPhone)' => array(
                    'alias'=>array('iPhone OS 8_4'),
                    'excludes'=>array()
                ),
                'iOS 8.3 (iPhone)' => array(
                    'alias'=>array('iPhone OS 8_3'),
                    'excludes'=>array()
                ),
                'iOS 8.2 (iPhone)' => array(
                    'alias'=>array('iPhone OS 8_2'),
                    'excludes'=>array()
                ),
                'iOS 8.1 (iPhone)' => array(
                    'alias'=>array('iPhone OS 8_1'),
                    'excludes'=>array()
                ),
                'iOS 8 (iPhone)' => array(
                    'alias'=>array('iPhone OS 8'),
                    'excludes'=>array()
                ),
                'iOS 7 (iPhone)' => array(
                    'alias'=>array('iPhone OS 7'),
                    'excludes'=>array()
                ),
                'iOS 6 (iPhone)' => array(
                    'alias'=>array('iPhone OS 6'),
                    'excludes'=>array()
                ),
                'iOS 5 (iPhone)' => array(
                    'alias'=>array('iPhone OS 5'),
                    'excludes'=>array()
                ),
                'iOS 4 (iPhone)' => array(
                    'alias'=>array('iPhone OS 4'),
                    'excludes'=>array()
                ),
                'iOS 9 (iPad)' => array(
                    'alias'=>array('OS 9'),
                    'excludes'=>array()
                ),
                'iOS 8.4 (iPad)' => array(
                    'alias'=>array('OS 8_4'),
                    'excludes'=>array()
                ),
                'iOS 8.3 (iPad)' => array(
                    'alias'=>array('OS 8_3'),
                    'excludes'=>array()
                ),
                'iOS 8.2 (iPad)' => array(
                    'alias'=>array('OS 8_2'),
                    'excludes'=>array()
                ),
                'iOS 8.1 (iPad)' => array(
                    'alias'=>array('OS 8_1'),
                    'excludes'=>array()
                ),
                'iOS 8 (iPad)' => array(
                    'alias'=>array('OS 8_0'),
                    'excludes'=>array()
                ),
                'iOS 7 (iPad)' => array(
                    'alias'=>array('OS 7'),
                    'excludes'=>array()
                ),
                'iOS 6 (iPad)' => array(
                    'alias'=>array('OS 6'),
                    'excludes'=>array()
                ),
                'Mac OS X (iPad)' => array(
                    'alias'=>array('iPad'),
                    'excludes'=>array()
                ),
                'Mac OS X (iPhone)' => array(
                    'alias'=>array('iPhone'),
                    'excludes'=>array()
                ),
                'Mac OS X (iPod)' => array(
                    'alias'=>array('iPod'),
                    'excludes'=>array()
                ),
                'iOS' => array(
                    'alias'=>array('iPhone OS', 'like Mac OS X'),
                    'excludes'=>array()
                ),
                'Mac OS X' => array(
                    'alias'=>array('Mac OS X', 'CFNetwork'),
                    'excludes'=>array()
                ),
                'Mac OS' => array(
                    'alias'=>array('Mac'),
                    'excludes'=>array()
                ),
                'Maemo' => array(
                    'alias'=>array('Maemo'),
                    'excludes'=>array()
                ),
                'Bada' => array(
                    'alias'=>array('Bada'),
                    'excludes'=>array()
                ),
                'Android (Google TV)' => array(
                    'alias'=>array('GoogleTV'),
                    'excludes'=>array()
                ),
                'Linux (Kindle 3)' => array(
                    'alias'=>array('Kindle/3'),
                    'excludes'=>array()
                ),
                'Linux (Kindle 2)' => array(
                    'alias'=>array('Kindle/2'),
                    'excludes'=>array()
                ),
                'Linux (Kindle)' => array(
                    'alias'=>array('Kindle'),
                    'excludes'=>array()
                ),
                'Ubuntu' => array(
                    'alias'=>array('ubuntu'),
                    'excludes'=>array()
                ),
                'Ubuntu Touch (mobile)' => array(
                    'alias'=>array('mobile'),
                    'excludes'=>array()
                ),
                'Linux' => array(
                    'alias'=>array('Linux', 'CamelHttpStream'),
                    'excludes'=>array()
                ),
                'Symbian OS 9.x' => array(
                    'alias'=>array('SymbianOS/9', 'Series60/3'),
                    'excludes'=>array()
                ),
                'Symbian OS 8.x' => array(
                    'alias'=>array('SymbianOS/8', 'Series60/2.6', 'Series60/2.8'),
                    'excludes'=>array()
                ),
                'Symbian OS 7.x' => array(
                    'alias'=>array('SymbianOS/7'),
                    'excludes'=>array()
                ),
                'Symbian OS 6.x' => array(
                    'alias'=>array('SymbianOS/6'),
                    'excludes'=>array()
                ),
                'Symbian OS' => array(
                    'alias'=>array('Symbian', 'Series60'),
                    'excludes'=>array()
                ),
                'Series 40' => array(
                    'alias'=>array('Nokia6300'),
                    'excludes'=>array()
                ),
                'Sony Ericsson' => array(
                    'alias'=>array('SonyEricsson'),
                    'excludes'=>array()
                ),
                'SunOS' => array(
                    'alias'=>array('SunOS'),
                    'excludes'=>array()
                ),
                'Sony Playstation' => array(
                    'alias'=>array('Playstation'),
                    'excludes'=>array()
                ),
                'Nintendo Wii' => array(
                    'alias'=>array('Wii'),
                    'excludes'=>array()
                ),
                'BlackBerry 7' => array(
                    'alias'=>array('Version/7'),
                    'excludes'=>array()
                ),
                'BlackBerry 6' => array(
                    'alias'=>array('Version/6'),
                    'excludes'=>array()
                ),
                'BlackBerry Tablet OS' => array(
                    'alias'=>array('RIM Tablet OS'),
                    'excludes'=>array()
                ),
                'BlackBerryOS' => array(
                    'alias'=>array('BlackBerry'),
                    'excludes'=>array()
                ),
                'Roku OS' => array(
                    'alias'=>array('Roku'),
                    'excludes'=>array()
                ),
                'Proxy' => array(
                    'alias'=>array('ggpht.com'),
                    'exclludes'=>array()
                ),
                'Unknown mobile' => array(
                    'alias'=>array('Mobile'),
                    'excludes'=>array()
                ),
                'Unknown tablet' => array(
                    'alias'=>array('Tablet'),
                    'excludes'=>array()
                ),
                'Unknown' => array(
                    'alias'=>array(),
                    'excludes'=>array()
                )
            );

            foreach ($operation_map as $name => $alias_excludes){
                if(isset($alias_excludes['alias']) && is_array($alias_excludes['alias']) && sizeof($alias_excludes['alias'])>0){
                    foreach ($alias_excludes['alias'] as $a) {
                        $a = strtolower($a);
                        $_a_pos = strpos($ua, $a);
                        $_ex_pos = false;
                        if ($_a_pos !== false) {
                            if (isset($alias_excludes['excludes']) && is_array($alias_excludes['excludes']) && sizeof($alias_excludes['excludes']) > 0) {
                                foreach ($alias_excludes['excludes'] as $ex) {
                                    $ex = strtolower($ex);
                                    $_ex_pos = strpos($ua, $ex);
                                }
                            }
                            if(isset($_a_pos) && isset($_ex_pos) && $_a_pos!==false && $_ex_pos===false){
                                return $name;
                            }
                        }
                    }
                }
            }
        }
        return false;
    }

    /**
     * 从 user-agent 通过映射关系获取 浏览器信息
     */
    public static function _getclientbrowser_for_userauth($_useragent){
        if(!empty($_useragent)){
            $ua = strtolower($_useragent);
            $browser_map = array(
                'Outlook 2007' => array(
                    'alias'=>array('MSOffice 12'),
                    'excludes'=>array()
                ),
                'Outlook 2013' => array(
                    'alias'=>array('Microsoft Outlook 15'),
                    'excludes'=>array()
                ),
                'Outlook 2010' => array(
                    'alias'=>array('MSOffice 14', 'Microsoft Outlook 14'),
                    'excludes'=>array()
                ),
                'Outlook' => array(
                    'alias'=>array('MSOffice'),
                    'excludes'=>array()
                ),
                'Windows Live Mail' => array(
                    'alias'=>array('Outlook-Express/7.0'),
                    'excludes'=>array()
                ),
                'IE Mobile 11' => array(
                    'alias'=>array('IEMobile/11'),
                    'excludes'=>array()
                ),
                'IE Mobile 10' => array(
                    'alias'=>array('IEMobile/10'),
                    'excludes'=>array()
                ),
                'IE Mobile 9' => array(
                    'alias'=>array('IEMobile/9'),
                    'excludes'=>array()
                ),
                'IE Mobile 7' => array(
                    'alias'=>array('IEMobile 7'),
                    'excludes'=>array()
                ),
                'IE Mobile 6' => array(
                    'alias'=>array('IEMobile 6'),
                    'excludes'=>array()
                ),
                'Xbox' => array(
                    'alias'=>array('xbox'),
                    'excludes'=>array()
                ),
                'Internet Explorer 11' => array(
                    'alias'=>array('Trident/7', 'IE 11.'),
                    'excludes'=>array('MSIE 7', 'BingPreview')
                ),
                'Internet Explorer 10' => array(
                    'alias'=>array('MSIE 10'),
                    'excludes'=>array()
                ),
                'Internet Explorer 9' => array(
                    'alias'=>array('MSIE 9'),
                    'excludes'=>array()
                ),
                'Internet Explorer 8' => array(
                    'alias'=>array('MSIE 8'),
                    'excludes'=>array()
                ),
                'Internet Explorer 7' => array(
                    'alias'=>array('MSIE 7'),
                    'excludes'=>array()
                ),
                'Internet Explorer 6' =>array(
                    'alias'=>array('MSIE 6'),
                    'excludes'=>array()
                ),
                'Internet Explorer 5.5' => array(
                    'alias'=>array('MSIE 5.5'),
                    'excludes'=>array()
                ),
                'Internet Explorer 5' => array(
                    'alias'=>array('MSIE 5'),
                    'excludes'=>array()
                ),
                'Internet Explorer' => array(
                    'alias'=>array('MSIE', 'Trident', 'IE '),
                    'excludes'=>array('BingPreview', 'Xbox', 'Xbox One')
                ),
                'Microsoft Edge Mobile' => array(
                    'alias'=>array('Mobile Safari'),
                    'excludes'=>array()
                ),
                'Microsoft Edge Mobile 12' => array(
                    'alias'=>array('Mobile Safari', 'Edge/12'),
                    'excludes'=>array()
                ),
                'Microsoft Edge 13' => array(
                    'alias'=>array('Edge/13'),
                    'excludes'=>array('Mobile')
                ),
                'Microsoft Edge 12' => array(
                    'alias'=>array('Edge/12'),
                    'excludes'=>array('Mobile')
                ),
                'Microsoft Edge' => array(
                    'alias'=>array('Edge'),
                    'excludes'=>array()
                ),
                'Chrome Mobile' => array(
                    'alias'=>array('CrMo', 'CriOS', 'Mobile Safari'),
                    'excludes'=>array('OPR/')
                ),
                'Chrome 49' => array(
                    'alias'=>array('Chrome/49'),
                    'excludes'=>array('OPR/', 'Web Preview', 'Vivaldi')
                ),
                'Chrome 48' => array(
                    'alias'=>array('Chrome/48'),
                    'excludes'=>array('OPR/', 'Web Preview', 'Vivaldi')
                ),
                'Chrome 47' => array(
                    'alias'=>array('Chrome/47'),
                    'excludes'=>array('OPR/', 'Web Preview', 'Vivaldi')
                ),
                'Chrome 46' => array(
                    'alias'=>array('Chrome/46'),
                    'excludes'=>array('OPR/', 'Web Preview', 'Vivaldi')
                ),
                'Chrome 45' => array(
                    'alias'=>array('Chrome/45'),
                    'excludes'=>array('OPR/', 'Web Preview', 'Vivaldi')
                ),
                'Chrome 44' => array(
                    'allias'=>array('Chrome/44'),
                    'excludes'=>array('OPR/', 'Web Preview', 'Vivaldi')
                ),
                'Chrome 43' => array(
                    'alias'=>array('Chrome/43'),
                    'excludes'=>array('OPR/', 'Web Preview', 'Vivaldi')
                ),
                'Chrome 42' => array(
                    'alias'=>array('Chrome/42'),
                    'excludes'=>array('OPR/', 'Web Preview', 'Vivaldi')
                ),
                'Chrome 41' => array(
                    'alias'=>array('Chrome/41'),
                    'excludes'=>array('OPR/', 'Web Preview', 'Vivaldi')
                ),
                'Chrome 40' => array(
                    'alias'=>array('Chrome/40'),
                    'excludes'=>array('OPR/', 'Web Preview', 'Vivaldi')
                ),
                'Chrome 39' => array(
                    'alias'=>array('Chrome/39'),
                    'excludes'=>array('OPR/', 'Web Preview')
                ),
                'Chrome 38' => array(
                    'alias'=>array('Chrome/38'),
                    'excludes'=>array('OPR/', 'Web Preview')
                ),
                'Chrome 37' => array(
                    'alias'=>array('Chrome/37'),
                    'excludes'=>array('OPR/', 'Web Preview')
                ),
                'Chrome 36' => array(
                    'alias'=>array('Chrome/36'),
                    'excludes'=>array('OPR/', 'Web Preview')
                ),
                'Chrome 35' => array(
                    'alias'=>array('Chrome/35'),
                    'excludes'=>array('OPR/', 'Web Preview')
                ),
                'Chrome 34' => array(
                    'alias'=>array('Chrome/34'),
                    'excludes'=>array('OPR/', 'Web Preview')
                ),
                'Chrome 33' => array(
                    'alias'=>array('Chrome/33'),
                    'excludes'=>array('OPR/', 'Web Preview')
                ),
                'Chrome 32' => array(
                    'alias'=>('Chrome/32'),
                    'excludes'=>array('OPR/', 'Web Preview')
                ),
                'Chrome 31' => array(
                    'alias'=>array('Chrome/31'),
                    'excludes'=>array('OPR/', 'Web Preview')
                ),
                'Chrome 30' => array(
                    'alias'=>array('Chrome/30'),
                    'excludes'=>array('OPR/', 'Web Preview')
                ),
                'Chrome 29' => array(
                    'alias'=>array('Chrome/29'),
                    'excludes'=>array('OPR/', 'Web Preview')
                ),
                'Chrome 28' => array(
                    'alias'=>array('Chrome/28'),
                    'excludes'=>array('OPR/', 'Web Preview')
                ),
                'Chrome 27' => array(
                    'alias'=>array('Chrome/27'),
                    'excludes'=>array('OPR/', 'Web Preview')
                ),
                'Chrome 26' => array(
                    'alias'=>array('Chrome/26'),
                    'excludes'=>array('OPR/', 'Web Preview')
                ),
                'Chrome 25' => array(
                    'alias'=>array('Chrome/25'),
                    'excludes'=>array('OPR/', 'Web Preview')
                ),
                'Chrome 24' => array(
                    'alias'=>array('Chrome/24'),
                    'excludes'=>array('OPR/', 'Web Preview')
                ),
                'Chrome 23' => array(
                    'alias'=>array('Chrome/23'),
                    'excludes'=>array('OPR/', 'Web Preview')
                ),
                'Chrome 22' => array(
                    'alias'=>array('Chrome/22'),
                    'excludes'=>array('OPR/', 'Web Preview')
                ),
                'Chrome 21' => array(
                    'alias'=>array('Chrome/21'),
                    'excludes'=>array('OPR/', 'Web Preview')
                ),
                'Chrome 20' => array(
                    'alias'=>array('Chrome/20'),
                    'excludes'=>array('OPR/', 'Web Preview')
                ),
                'Chrome 19' => array(
                    'alias'=>array('Chrome/19'),
                    'excludes'=>array('OPR/', 'Web Preview')
                ),
                'Chrome 18' => array(
                    'alias'=>array('Chrome/18'),
                    'excludes'=>array()
                ),
                'Chrome 17' => array(
                    'alias'=>array('Chrome/17'),
                    'excludes'=>array()
                ),
                'Chrome 16' => array(
                    'alias'=>array('Chrome/16'),
                    'excludes'=>array()
                ),
                'Chrome 15' => array(
                    'alias'=>array('Chrome/15'),
                    'excludes'=>array()
                ),
                'Chrome 14' => array(
                    'alias'=>array('Chrome/14'),
                    'excludes'=>array()
                ),
                'Chrome 13' => array(
                    'alias'=>array('Chrome/13'),
                    'excludes'=>array()
                ),
                'Chrome 12' => array(
                    'alias'=>array('Chrome/12'),
                    'excludes'=>array()
                ),
                'Chrome 11' => array(
                    'alias'=>array('Chrome/11'),
                    'excludes'=>array()
                ),
                'Chrome 10' => array(
                    'alias'=>array('Chrome/10'),
                    'excludes'=>array()
                ),
                'Chrome 9' => array(
                    'alias'=>array('Chrome/9'),
                    'excludes'=>array()
                ),
                'Chrome 8' => array(
                    'alias'=>array('Chrome/8'),
                    'excludes'=>array()
                ),
                'Chrome' => array(
                    'alias'=>array('Chrome', 'CrMo', 'CriOS'),
                    'excludes'=>array('OPR/', 'Web Preview', 'Vivaldi')
                ),
                'Omniweb' => array(
                    'alias'=>array('OmniWeb'),
                    'excludes'=>array()
                ),
                'Firefox 3 Mobile' => array(
                    'alias'=>array('Firefox/3.5 Maemo'),
                    'excludes'=>array()
                ),
                'Firefox Mobile' => array(
                    'alias'=>array('Mobile'),
                    'excludes'=>array()
                ),
                'Firefox Mobile 23' => array(
                    'alias'=>array('Firefox/23'),
                    'excludes'=>array()
                ),
                'Firefox Mobile (iOS)' => array(
                    'alias'=>array('FxiOS'),
                    'excludes'=>array()
                ),
                'Firefox 45' => array(
                    'alias'=>array('Firefox/45'),
                    'excludes'=>array()
                ),
                'Firefox 44'=> array(
                    'alias'=>array('Firefox/44'),
                    'excludes'=>array()
                ),
                'Firefox 43' => array(
                    'alias'=>array('Firefox/43'),
                    'excludes'=>array()
                ),
                'Firefox 42' => array(
                    'alias'=>array('Firefox/42'),
                    'excludes'=>array()
                ),
                'Firefox 41' => array(
                    'alias'=>array('Firefox/41'),
                    'excludes'=>array()
                ),
                'Firefox 40' => array(
                    'alias'=>array('Firefox/40'),
                    'excludes'=>array()
                ),
                'Firefox 39' => array(
                    'alias'=>array('Firefox/39'),
                    'excludes'=>array()
                ),
                'Firefox 38' => array(
                    'alias'=>array('Firefox/38'),
                    'excludes'=>array()
                ),
                'Firefox 37' => array(
                    'alias'=>array('Firefox/37'),
                    'excludes'=>array()
                ),
                'Firefox 36' => array(
                    'alias'=>array('Firefox/36'),
                    'excludes'=>array()
                ),
                'Firefox 35' => array(
                    'alias'=>array('Firefox/35'),
                    'excludes'=>array()
                ),
                'Firefox 34' => array(
                    'alias'=>array('Firefox/34'),
                    'excludes'=>array()
                ),
                'Firefox 33' => array(
                    'alias'=>array('Firefox/33'),
                    'excludes'=>array()
                ),
                'Firefox 32' => array(
                    'alias'=>array('Firefox/32'),
                    'excludes'=>array()
                ),
                'Firefox 31' => array(
                    'alias'=>array('Firefox/31'),
                    'excludes'=>array()
                ),
                'Firefox 30' => array(
                    'alias'=>array('Firefox/30'),
                    'excludes'=>array()
                ),
                'Firefox 29' => array(
                    'alias'=>array('Firefox/29'),
                    'excludes'=>array()
                ),
                'Firefox 28' => array(
                    'alias'=>array('Firefox/28'),
                    'excludes'=>array()
                ),
                'Firefox 27' => array(
                    'alias'=>array('Firefox/27'),
                    'excludes'=>array()
                ),
                'Firefox 26' => array(
                    'alias'=>array('Firefox/26'),
                    'excludes'=>array()
                ),
                'Firefox 25' => array(
                    'alias'=>array('Firefox/25'),
                    'excludes'=>array()
                ),
                'Firefox 24' => array(
                    'alias'=>array('Firefox/24'),
                    'excludes'=>array()
                ),
                'Firefox 23' => array(
                    'alias'=>array('Firefox/23'),
                    'excludes'=>array()
                ),
                'Firefox 22' => array(
                    'alias'=>array('Firefox/22'),
                    'excludes'=>array()
                ),
                'Firefox 21' => array(
                    'alias'=>array('Firefox/21'),
                    'excludes'=>array('WordPress.com mShots')
                ),
                'Firefox 20' => array(
                    'alias'=>array('Firefox/20'),
                    'excludes'=>array()
                ),
                'Firefox 19' => array(
                    'alias'=>array('Firefox/19'),
                    'excludes'=>array()
                ),'Firefox 18' => array(
                    'alias'=>array('Firefox/18'),
                    'excludes'=>array()
                ),
                'Firefox 17' => array(
                    'alias'=>array('Firefox/17'),
                    'excludes'=>array()
                ),
                'Firefox 16' => array(
                    'alias'=>array('Firefox/16'),
                    'excludes'=>array()
                ),
                'Firefox 15' => array(
                    'alias'=>array('Firefox/15'),
                    'excludes'=>array()
                ),
                'Firefox 14' => array(
                    'alias'=>array('Firefox/14'),
                    'excludes'=>array()
                ),
                'Firefox 13' => array(
                    'alias'=>array('Firefox/13'),
                    'excludes'=>array()
                ),
                'Firefox 12' => array(
                    'alias'=>array('Firefox/12'),
                    'excludes'=>array()
                ),
                'Firefox 11' => array(
                    'alias'=>array('Firefox/11'),
                    'excludes'=>array()
                ),
                'Firefox 10' => array(
                    'alias'=>array('Firefox/10'),
                    'excludes'=>array()
                ),
                'Firefox 9' => array(
                    'alias'=>array('Firefox/9'),
                    'excludes'=>array()
                ),
                'Firefox 8' => array(
                    'alias'=>array('Firefox/8'),
                    'excludes'=>array()
                ),
                'Firefox 7' => array(
                    'alias'=>array('Firefox/7'),
                    'excludes'=>array()
                ),
                'Firefox 6' => array(
                    'alias'=>array('Firefox/6.'),
                    'excludes'=>array()
                ),
                'Firefox 5' => array(
                    'alias'=>array('Firefox/5.'),
                    'excludes'=>array()
                ),
                'Firefox 4' => array(
                    'alias'=>array('Firefox/4.'),
                    'excludes'=>array()
                ),
                'Firefox 3' => array(
                    'alias'=>array('Firefox/3.'),
                    'excludes'=>array('Camino', 'Flock', 'ggpht.com')
                ),
                'Firefox 2' => array(
                    'alias'=>array('Firefox/2.'),
                    'excludes'=>array('Camino', 'WordPress.com mShots')
                ),
                'Firefox 1.5' => array(
                    'alias'=>array('Firefox/1.5'),
                    'excludes'=>array()
                ),
                'Firefox' => array(
                    'alias'=>array('Firefox', 'FxiOS'),
                    'excludes'=>array('camino', 'flock', 'ggpht.com', 'WordPress.com mShots')
                ),
                'BlackBerry' => array(
                    'alias'=>array('BB10'),
                    'excludes'=>array()
                ),
                'Mobile Safari' => array(
                    'alias'=>array('Mobile Safari', 'Mobile/'),
                    'excludes'=>array('bot', 'preview', 'OPR/', 'Coast/', 'Vivaldi', 'CFNetwork', 'FxiOS')
                ),
                'Silk' => array(
                    'alias'=>array('Silk/'),
                    'excludes'=>array()
                ),
                'Safari 9' => array(
                    'alias'=>array('Version/9'),
                    'excludes'=>array('Applebot')
                ),
                'Safari 8' => array(
                    'alias'=>array('Version/8'),
                    'excludes'=>array('Applebot')
                ),
                'Safari 7' => array(
                    'alias'=>array('Version/7'),
                    'excludes'=>array('bing')
                ),
                'Safari 6' => array(
                    'alias'=>array('Version/6'),
                    'excludes'=>array()
                ),
                'Safari 5' => array(
                    'alias'=>array('Version/5'),
                    'excludes'=>array('Google Web Preview')
                ),
                'Safari 4' => array(
                    'alias'=>array('Version/4'),
                    'excludes'=>array('Googlebot-Mobile')
                ),
                'Safari' => array(
                    'alias'=>array('Safari'),
                    'excludes'=>array('bot', 'preview', 'OPR/', 'Coast/', 'Vivaldi', 'CFNetwork', 'Phantom')
                ),
                'Opera' => array(
                    'alias'=>array(' Coast/1.'),
                    'excludes'=>array()
                ),
                'Opera' => array(
                    'alias'=>array(' Coast/'),
                    'excludes'=>array()
                ),
                'Opera Mobile' => array(
                    'alias'=>array('Mobile Safari'),
                    'excludes'=>array()
                ),
                'Opera Mini' => array(
                    'alias'=>array('Opera Mini'),
                    'excludes'=>array()
                ),
                'Opera 34' => array(
                    'alias'=>array('OPR/34.'),
                    'excludes'=>array()
                ),
                'Opera 33' => array(
                    'alias'=>array('OPR/33.'),
                    'excludes'=>array()
                ),
                'Opera 32' => array(
                    'alias'=>array('OPR/32.'),
                    'excludes'=>array()
                ),
                'Opera 31' => array(
                    'alias'=>array('OPR/31.'),
                    'excludes'=>array()
                ),
                'Opera 30' => array(
                    'alias'=>array('OPR/30.'),
                    'excludes'=>array()
                ),
                'Opera 29' => array(
                    'alias'=>array('OPR/29.'),
                    'excludes'=>array()
                ),
                'Opera 28' => array(
                    'alias'=>array('OPR/28.'),
                    'excludes'=>array()
                ),
                'Opera 27' => array(
                    'alias'=>array('OPR/27.'),
                    'excludes'=>array()
                ),
                'Opera 26' => array(
                    'alias'=>array('OPR/26.'),
                    'excludes'=>array()
                ),
                'Opera 25' => array(
                    'alias'=>array('OPR/25.'),
                    'excludes'=>array()
                ),
                'Opera 24' => array(
                    'alias'=>array('OPR/24.'),
                    'excludes'=>array()
                ),
                'Opera 23' => array(
                    'alias'=>array('OPR/23.'),
                    'excludes'=>array()
                ),
                'Opera 20' => array(
                    'alias'=>array('OPR/20.'),
                    'excludes'=>array()
                ),
                'Opera 19' => array(
                    'alias'=>array('OPR/19.'),
                    'excludes'=>array()
                ),
                'Opera 18' => array(
                    'alias'=>array('OPR/18.'),
                    'excludes'=>array()
                ),
                'Opera 17' => array(
                    'alias'=>array('OPR/17.'),
                    'excludes'=>array()
                ),
                'Opera 16' => array(
                    'alias'=>array('OPR/16.'),
                    'excludes'=>array()
                ),
                'Opera 15' => array(
                    'alias'=>array('OPR/15.'),
                    'excludes'=>array()
                ),
                'Opera 12' => array(
                    'alias'=>array('Opera/12', 'Version/12.'),
                    'excludes'=>array()
                ),
                'Opera 11' => array(
                    'alias'=>array('Version/11.'),
                    'excludes'=>array()
                ),
                'Opera 10' => array(
                    'alias'=>array('Opera/9.8'),
                    'excludes'=>array()
                ),
                'Opera 9' => array(
                    'alias'=>array('Opera/9'),
                    'excludes'=>array()
                ),
                'Opera' => array(
                    'alias'=>array(' OPR/', 'Opera'),
                    'excludes'=>array()
                ),
                'Konqueror' => array(
                    'alias'=>array('Konqueror'),
                    'excludes'=>array('Exabot')
                ),
                'Samsung Dolphin 2' => array(
                    'alias'=>array('Dolfin/2'),
                    'excludes'=>array()
                ),
                'iTunes' => array(
                    'alias'=>array('iTunes'),
                    'excludes'=>array()
                ),
                'App Store' => array(
                    'alias'=>array('MacAppStore'),
                    'excludes'=>array()
                ),
                'Adobe AIR application' => array(
                    'alias'=>array('AdobeAIR'),
                    'excludes'=>array()
                ),
                'Apple WebKit' => array(
                    'alias'=>array('AppleWebKit'),
                    'excludes'=>array('bot', 'preview', 'OPR/', 'Coast/', 'Vivaldi', 'Phantom')
                ),
                'Lotus Notes' => array(
                    'alias'=>array('Lotus-Notes'),
                    'excludes'=>array()
                ),
                'Camino' => array(
                    'alias'=>array('Camino'),
                    'excludes'=>array()
                ),
                'Camino 2' => array(
                    'alias'=>array('Camino/2'),
                    'excludes'=>array()
                ),
                'Flock' => array(
                    'alias'=>array('Flock'),
                    'excludes'=>array()
                ),
                'Thunderbird 12' => array(
                    'alias'=>array('Thunderbird/12'),
                    'excludes'=>array()
                ),
                'Thunderbird 11' => array(
                    'alias'=>array('Thunderbird/11'),
                    'excludes'=>array()
                ),
                'Thunderbird 10' => array(
                    'alias'=>array('Thunderbird/10'),
                    'excludes'=>array()
                ),
                'Thunderbird 8' => array(
                    'alias'=>array('Thunderbird/8'),
                    'excludes'=>array()
                ),
                'Thunderbird 7' => array(
                    'alias'=>array('Thunderbird/7'),
                    'excludes'=>array()
                ),
                'Thunderbird 6' => array(
                    'alias'=>array('Thunderbird/6'),
                    'excludes'=>array()
                ),
                'Thunderbird 3' => array(
                    'alias'=>array('Thunderbird/3'),
                    'excludes'=>array()
                ),
                'Thunderbird 2' => array(
                    'alias'=>array('Thunderbird/2'),
                    'excludes'=>array()
                ),
                'Thunderbird' => array(
                    'alias'=>array('Thunderbird'),
                    'excludes'=>array()
                ),
                'Vivaldi' => array(
                    'alias'=>array('Vivaldi'),
                    'excludes'=>array()
                ),
                'SeaMonkey' => array(
                    'alias'=>array('SeaMonkey'),
                    'excludes'=>array()
                ),
                'Mobil Robot/Spider' => array(
                    'alias'=>array('Googlebot-Mobile'),
                    'excludes'=>array()
                ),
                'Robot/Spider' => array(
                    'alias'=>array('Googlebot', 'Mediapartners-Google', 'Web Preview', 'bot', 'Applebot', 'spider', 'crawler', 'Feedfetcher', 'Slurp',
                        'Twiceler', 'Nutch', 'BecomeBot', 'bingbot', 'BingPreview', 'Google Web Preview', 'WordPress.com mShots', 'Seznam',
                        'facebookexternalhit', 'YandexMarket', 'Teoma', 'ThumbSniper', 'Phantom'),
                    'excludes'=>array()
                ),
                'Mozilla' => array(
                    'alias'=>array('Mozilla', 'Moozilla'),
                    'excludes'=>array('ggpht.com')
                ),
                'CFNetwork' => array(
                    'alias'=>array('CFNetwork'),
                    'excludes'=>array()
                ),
                'Eudora' => array(
                    'alias'=>array('Eudora', 'EUDORA'),
                    'excludes'=>array()
                ),
                'PocoMail' => array(
                    'alias'=>array('PocoMail'),
                    'excludes'=>array()
                ),
                'The Bat!' => array(
                    'alias'=>array('The Bat'),
                    'excludes'=>array()
                ),
                'NetFront' => array(
                    'alias'=>array('NetFront'),
                    'excludes'=>array()
                ),
                'Evolution' => array(
                    'alias'=>array('CamelHttpStream'),
                    'excludes'=>array()
                ),
                'Lynx' => array(
                    'alias'=>array('Lynx'),
                    'excludes'=>array()
                ),
                'Downloading Tool' => array(
                    'alias'=>array('cURL', 'wget', 'ggpht.com', 'Apache-HttpClient'),
                    'excludes'=>array()
                ),
                'Unknown' => array(
                    'alias'=>array(),
                    'excludes'=>array()
                )
            );

            foreach ($browser_map as $name => $alias_excludes){
                if(isset($alias_excludes['alias']) && is_array($alias_excludes['alias']) && sizeof($alias_excludes['alias'])>0){
                    foreach ($alias_excludes['alias'] as $a){
                        $a = strtolower($a);
                        $_a_pos = strpos($ua, $a);
                        $_ex_pos = false;
                        if ($_a_pos !== false) {
                            if (isset($alias_excludes['excludes']) && is_array($alias_excludes['excludes']) && sizeof($alias_excludes['excludes']) > 0) {
                                foreach ($alias_excludes['excludes'] as $ex) {
                                    $ex = strtolower($ex);
                                    $_ex_pos = strpos($ua, $ex);
                                }
                            }
                            if(isset($_a_pos) && isset($_ex_pos) && $_a_pos!==false && $_ex_pos===false){
                                return $name;
                            }
                        }
                    }
                }
            }
        }
        return false;
    }

}


/**
 *   类名: mobile
 *   描述: 手机信息类
 *   其他:
 */
class mobile
{
    /**
     * 函数名称: getPhoneNumber
     * 函数功能: 取手机号
     * 输入参数: none
     * 函数返回值: 成功返回号码，失败返回false
     * 其它说明: 说明
     */
    function getPhoneNumber()
    {
        if (isset($_SERVER['HTTP_X_NETWORK_INFO'])) {
            $str1 = $_SERVER['HTTP_X_NETWORK_INFO'];
            $getstr1 = preg_replace('/(.*,)(13[\d]{9})(,.*)/i', '\\2', $str1);
            Return $getstr1;
        } elseif (isset($_SERVER['HTTP_X_UP_CALLING_LINE_ID'])) {
            $getstr2 = $_SERVER['HTTP_X_UP_CALLING_LINE_ID'];
            Return $getstr2;
        } elseif (isset($_SERVER['HTTP_X_UP_SUBNO'])) {
            $str3 = $_SERVER['HTTP_X_UP_SUBNO'];
            $getstr3 = preg_replace('/(.*)(13[\d]{9})(.*)/i', '\\2', $str3);
            Return $getstr3;
        } elseif (isset($_SERVER['DEVICEID'])) {
            Return $_SERVER['DEVICEID'];
        } else {
            Return false;
        }
    }

    /**
     * 函数名称: getHttpHeader
     * 函数功能: 取头信息
     * 输入参数: none
     * 函数返回值: 成功返回号码，失败返回false
     * 其它说明: 说明
     */
    function getHttpHeader()
    {
        $str = '';
        foreach ($_SERVER as $key => $val) {
            $gstr = str_replace("&", "&amp;", $val);
            $str .= "$key -> " . $gstr . "\r\n";
        }
        Return $str;
    }

    /**
     * 函数名称: getUA
     * 函数功能: 取UA
     * 输入参数: none
     * 函数返回值: 成功返回号码，失败返回false
     * 其它说明: 说明
     */
    function getUA()
    {
        if (isset($_SERVER['HTTP_USER_AGENT'])) {
            Return $_SERVER['HTTP_USER_AGENT'];
        } else {
            Return false;
        }
    }

    /**
     * 函数名称: getPhoneType
     * 函数功能: 取得手机类型
     * 输入参数: none
     * 函数返回值: 成功返回string，失败返回false
     * 其它说明: 说明
     */
    function getPhoneType()
    {
        $ua = $this->getUA();
        if ($ua != false) {
            $str = explode(' ', $ua);
            Return $str[0];
        } else {
            Return false;
        }
    }

    /**
     * 函数名称: isOpera
     * 函数功能: 判断是否是opera
     * 输入参数: none
     * 函数返回值: 成功返回string，失败返回false
     * 其它说明: 说明
     */
    function isOpera()
    {
        $uainfo = $this->getUA();
        if (preg_match('/.*Opera.*/i', $uainfo)) {
            Return true;
        } else {
            Return false;
        }
    }

    /**
     * 函数名称: isM3gate
     * 函数功能: 判断是否是m3gate
     * 输入参数: none
     * 函数返回值: 成功返回string，失败返回false
     * 其它说明: 说明
     */
    function isM3gate()
    {
        $uainfo = $this->getUA();
        if (preg_match('/M3Gate/i', $uainfo)) {
            Return true;
        } else {
            Return false;
        }
    }

    /**
     * 函数名称: getHttpAccept
     * 函数功能: 取得HA
     * 输入参数: none
     * 函数返回值: 成功返回string，失败返回false
     * 其它说明: 说明
     */
    function getHttpAccept()
    {
        if (isset($_SERVER['HTTP_ACCEPT'])) {
            Return $_SERVER['HTTP_ACCEPT'];
        } else {
            Return false;
        }
    }

    /**
     * 函数名称: getIP
     * 函数功能: 取得手机IP
     * 输入参数: none
     * 函数返回值: 成功返回string
     * 其它说明: 说明
     */
    function getIP()
    {
        $ip = getenv('REMOTE_ADDR');
        $ip_ = getenv('HTTP_X_FORWARDED_FOR');
        if (($ip_ != "") && ($ip_ != "unknown")) {
            $ip = $ip_;
        }
        return $ip;
    }

    /**
     * 获取手机类型
     * @return string
     */
    function get_device_type()
    {
        //全部变成小写字母
        $agent = strtolower($_SERVER['HTTP_USER_AGENT']);
        $type = 'other';
        //分别进行判断
        if(strpos($agent, 'iphone') || strpos($agent, 'ipad'))
        {
            $type = 'ios';
        }

        if(strpos($agent, 'android'))
        {
            $type = 'android';
        }
        return $type;
    }

    public function get_phone_name()
    {
        $user_agent = $_SERVER['HTTP_USER_AGENT'];
        if (stripos($user_agent, "iPhone")!==false) {
            $brand = 'iPhone';
        } else if (stripos($user_agent, "SAMSUNG")!==false || stripos($user_agent, "Galaxy")!==false || strpos($user_agent, "GT-")!==false || strpos($user_agent, "SCH-")!==false || strpos($user_agent, "SM-")!==false) {
            $brand = '三星';
        } else if (stripos($user_agent, "Huawei")!==false || stripos($user_agent, "Honor")!==false || stripos($user_agent, "H60-")!==false || stripos($user_agent, "H30-")!==false) {
            $brand = '华为';
        } else if (stripos($user_agent, "Lenovo")!==false) {
            $brand = '联想';
        } else if (stripos($user_agent, "Xiaomi")!==false ||strpos($user_agent, "MI-ONE")!==false || strpos($user_agent, "MI 1S")!==false || strpos($user_agent, "MI 2")!==false || strpos($user_agent, "MI 3")!==false || strpos($user_agent, "MI 4")!==false || strpos($user_agent, "MI-4")!==false) {
            $brand = '小米';
        } else if (strpos($user_agent, "HM NOTE")!==false || strpos($user_agent, "HM201")!==false) {
            $brand = '红米';
        } else if (stripos($user_agent, "Coolpad")!==false || strpos($user_agent, "8190Q")!==false || strpos($user_agent, "5910")!==false) {
            $brand = '酷派';
        } else if (stripos($user_agent, "ZTE")!==false || stripos($user_agent, "X9180")!==false || stripos($user_agent, "N9180")!==false || stripos($user_agent, "U9180")!==false) {
            $brand = '中兴';
        } else if (stripos($user_agent, "OPPO")!==false || strpos($user_agent, "X9007")!==false || strpos($user_agent, "X907")!==false || strpos($user_agent, "X909")!==false || strpos($user_agent, "R831S")!==false || strpos($user_agent, "R827T")!==false || strpos($user_agent, "R821T")!==false || strpos($user_agent, "R811")!==false || strpos($user_agent, "R2017")!==false) {
            $brand = 'OPPO';
        } else if (strpos($user_agent, "HTC")!==false || stripos($user_agent, "Desire")!==false) {
            $brand = 'HTC';
        } else if (stripos($user_agent, "vivo")!==false) {
            $brand = 'vivo';
        } else if (stripos($user_agent, "K-Touch")!==false) {
            $brand = '天语';
        } else if (stripos($user_agent, "Nubia")!==false || stripos($user_agent, "NX50")!==false || stripos($user_agent, "NX40")!==false) {
            $brand = '努比亚';
        } else if (strpos($user_agent, "M045")!==false || strpos($user_agent, "M032")!==false || strpos($user_agent, "M355")!==false) {
            $brand = '魅族';
        } else if (stripos($user_agent, "DOOV")!==false) {
            $brand = '朵唯';
        } else if (stripos($user_agent, "GFIVE")!==false) {
            $brand = '基伍';
        } else if (stripos($user_agent, "Gionee")!==false || strpos($user_agent, "GN")!==false) {
            $brand = '金立';
        } else if (stripos($user_agent, "HS-U")!==false || stripos($user_agent, "HS-E")!==false) {
            $brand = '海信';
        } else if (stripos($user_agent, "Nokia")!==false) {
            $brand = '诺基亚';
        } else {
            $brand = '其他手机';
        }
        return $brand;
    }
}

