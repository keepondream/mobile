<?php
/**
 * Created by PhpStorm.
 * User: dream
 * Date: 2018/8/7
 * Time: 下午11:23
 */

namespace App\Libraries\Sms51ym;

use App\Common\Common;
use App\http\Model\MobileLog;
use App\User;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Redis;

class Sms51ym
{
    private static $password = '198522';
    private static $username = 'Fanleguan';
    private static $baseurl = 'http://api.fxhyd.cn/UserInterface.aspx';
    private static $token = '';                             //token
    protected static $client = '';                          //guzzle 初始化对象
    protected static $userInfo = '';                        //账户基本信息 success|用户名|账户状态|账户等级|账户余额|冻结金额|账户折扣|获取号码最大数量
                                                            //success|{"UserName":"fanleguan","UserLevel":1,"MaxHold":1000,"Discount":1.000,"Balance":89.9000,"Status":1,"Frozen":1475.0000}

    public function __construct()
    {

        self::$client = new Client(['base_uri' => self::$baseurl]);
        # Redis使用方法
        //Redis::set('sms51ymtoken','111','EX',10);  //指定过期时间

        # guzzle 使用方法
        //post 请求 易码不支持post 获取action
        /*$response = $this->client->request('POST', $this->baseurl, [
            'form_params' => $params
        ]);
        var_dump($response->getStatusCode());
        var_dump($response->getHeaderLine('content-type'));
        var_dump($response->getBody()->getContents());*/

        //获取Redis缓存token 并赋值
        $token = Redis::get(md5('sms51ymtoken'));
        if (empty($token)) {
            self::getToken();
        } else {
            self::$token = $token;
        }

        //获取账户信息 并赋值
        self::getUserInfo();

        return $this;
    }

    /**
     * 获取登陆token
     */
    public static function getToken($a = 0)
    {
        //最大重复执行5次
        if ($a < 5) {
            $params = [
                'action' => 'login',
                'username' => self::$username,
                'password' => self::$password
            ];
            //get请求
            $response = self::$client->request('GET', self::$baseurl, [
                'query' => $params
            ]);
            $res = $response->getBody()->getContents();
            if (!empty($res)) {
                $tokenArr = explode('|', $res);
                if (!empty($tokenArr[0]) && $tokenArr[0] == 'success') {
                    Redis::set(md5('sms51ymtoken'),$tokenArr[1],'EX',14400);//存储4小时
                    self::$token = $tokenArr[1];
                } else {
                    sleep(5);
                    $repetition = $a + 1;
                    self::getToken($repetition);
                }
            }
        }
    }

    /**
     * 获取账户基本信息
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public static function getUserInfo()
    {
        $params = [
            'action' => 'getaccountinfo',
            'token' => self::$token,
            'format' => 1
        ];
        //get请求
        $response = self::$client->request('GET', self::$baseurl, [
            'query' => $params
        ]);

        $res = $response->getBody()->getContents();
        if (!empty($res)) {
            $infoArr = explode('|', $res);
            if (!empty($infoArr[0]) && $infoArr[0] == 'success') {
                $infoData = json_decode($infoArr[1],true);
                self::$userInfo = $infoData;
            } else {
                self::getToken();
            }
        }
        return self::$userInfo;
    }

    /**
     * 获取手机号
     * @param $type     操作标识类型,给Redis不同的类型处理不同的事情
     * @param $memberid 用户ID
     * @param $orderid  订单ID
     * @param $num      获取总数
     * @param $data     获取条件
     * @param $repetition     重复获取次数
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public static function getMobile($type,$memberid,$orderid,$num,$data,$repetition=0)
    {
        if ($type == 'yimagetmobile') {
            $brandname = '易码平台';
        }
        //将数据组装用于Redis 和 结果返出
        $getMobile = [
            'type' => $type,
            'orderid' => $orderid,
            'num' => $num,
            'memberid' => $memberid,
            'data' => $data,
            'repetition' => $repetition + 1
        ];

        //调用60后就放弃调用 就是 300秒
        if ($repetition >= 60) {
            $data = [
                'user_id' => $memberid,
                'order_id' => $orderid,
                'num' => $num,
                'mobile_status' => '2',
                'get_mobile_time' => time(),
                'mobile_repetition' => $repetition,
                'brand_name' => $brandname
            ];
            MobileLog::create($data);
            return Common::jsonOutData(201,'手机号获取失败',$getMobile);
        }
//
//        //------调试----
//        Redis::Rpush(md5('mobile'),json_encode($getMobile));
//        return Common::jsonOutData(202,'获取手机号错误信息',$getMobile);
//        //------结束----
//


        $params = [
            'action' => 'getmobile',
            'token' => self::$token,
        ];
        if (!empty($data) && is_array($data)) {
            $param = array_merge($params,$data);
        }
        $response = self::$client->request('GET', self::$baseurl, [
            'query' => $param
        ]);
        $res = $response->getBody()->getContents();
        if (!empty($res)) {
            $mobileArr = explode('|', $res);
            if (!empty($mobileArr[0]) && $mobileArr[0] == 'success') {
                $mobile = $mobileArr[1];
                //进行数据库存储
                $data = [
                    'user_id' => $memberid,
                    'order_id' => $orderid,
                    'num' => $num,
                    'mobile' => $mobile,
                    'mobile_status' => '1',
                    'get_mobile_time' => time(),
                    'mobile_repetition' => $repetition,
                    'brand_name' => $brandname
                ];
                MobileLog::create($data);
                //成功获取扣除用户积分 -----------------以后规则待定----------暂时 一条扣10分
                $userModel = User::find($memberid);
                $userModel->credit = $userModel->credit - 10;
                $userModel->save();
                return Common::jsonOutData(200,'手机号获取成功',$getMobile);
            } else {
                //将用户数据存入redis 定时执行
                Redis::Rpush(md5('mobile'),json_encode($getMobile));
                return Common::jsonOutData(202,'获取手机号错误信息'.$res,$getMobile);
            }
        }
    }

    public static function actionIndex()
    {
        return '51ym';
    }

}