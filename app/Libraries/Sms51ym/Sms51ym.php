<?php
/**
 * Created by PhpStorm.
 * User: dream
 * Date: 2018/8/7
 * Time: 下午11:23
 */

namespace App\Libraries\Sms51ym;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Redis;

class Sms51ym
{
    private $password = '198522';
    private $username = 'Fanleguan';
    private $baseurl = 'http://api.fxhyd.cn/UserInterface.aspx';
    private $token = '';

    protected $client = '';

    public function __construct()
    {
        $this->client = new Client(['base_uri' => $this->baseurl]);
//            Redis::set('sms51ymtoken','111','EX',10);  //指定过期时间

        $token = Redis::get('sms51ymtoken');
        dump($token);
//        if (empty($token)) {
//            Redis::set('sms51ymtoken','111',10);
//            dd(Redis::get('sms51ymtoken'));
//        } else {
//            $this->token = $token;
//        }
        dd($token);
    }

    /**
     * 获取登陆token
     */
    public function Token()
    {
        $params = [
            'action' => 'login',
            'username' => $this->username,
            'password' => $this->password
        ];
        //或者将URL地址中代写action
        //get请求
        $response = $this->client->request('GET', $this->baseurl, [
            'query' => $params
        ]);

        //post 请求 易码不支持post 获取action
//        $response = $this->client->request('POST', $this->baseurl, [
//            'form_params' => $params
//        ]);

//        var_dump($response->getStatusCode());
//        var_dump($response->getHeaderLine('content-type'));
//        var_dump($response->getBody()->getContents());
//        exit;
        dd($response->getBody());
    }

    public static function actionIndex()
    {
        return '51ym';
    }

}