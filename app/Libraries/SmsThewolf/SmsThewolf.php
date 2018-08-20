<?php
/**
 * Created by PhpStorm.
 * User: dream
 * Date: 2018/8/20
 * Time: 下午10:41
 */

namespace App\Libraries\SmsThewolf;


use GuzzleHttp\Client;
use Illuminate\Support\Facades\Redis;

class SmsThewolf
{
    private static $password = '';
    private static $username = '';
    private static $token = '';

    private static $baseurl = 'http://api.yyyzmpt.com/index.php/';
    protected static $client = '';

    public function __construct()
    {
        self::$username = env('APP_THEWOLFNAME');
        self::$password = env('APP_THEWOLFPWD');

        self::$client = new Client(['base_uri'=>self::$baseurl]);

        $token = Redis::get(md5('smsthewolftoken'));
        if (empty($token)) {
            self::getToken();
        } else {
            self::$token = json_decode($token,true)['token'];
        }

    }

    /**
     * 获取token 并存储Redis
     * @param int $a
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public static function getToken($a = 0)
    {
        if ($a < 5) {
            $params = [
                'username' => self::$username,
                'password' => self::$password
            ];
            $response = self::$client->request('POST','reg/login',[
               'form_params' => $params
            ]);
            $res = $response->getBody()->getContents();
            if (!empty($res)) {
                $res = json_decode($res,true);
                if ($res['errno'] == 0) {
                    self::$token = $res['ret']['token'];
                    $res['ret']['leng'] += time();
                    //进行Redis 存储
                    Redis::set(md5('smsthewolftoken'),json_encode($res['ret']));
                } else {
                    sleep(5);
                    $repetition = $a + 1;
                    self::getToken($repetition);
                }
            }
        }
    }
}