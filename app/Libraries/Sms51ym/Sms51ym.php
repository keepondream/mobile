<?php
/**
 * Created by PhpStorm.
 * User: dream
 * Date: 2018/8/7
 * Time: 下午11:23
 */

namespace App\Libraries\Sms51ym;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Cache;

class Sms51ym
{
    private $password = '198522';
    private $username = 'Fanleguan';
    private $token = '';

    protected $client = '';

    public function __construct()
    {
        $this->client = new Client();

        $token = Cache::get('sms51ymtoken');
        if (empty($token)) {
            dd($this->Token());
        } else {
            $this->token = $token;
        }
        dd($token);
    }

    public function Token()
    {
        $response = $this->client->request('GET', 'http://api.fxhyd.cn/UserInterface.aspx?action=login&username='.$this->username.'&password='.$this->password);
        var_dump($response->getStatusCode());
        var_dump($response->getHeaderLine('content-type'));
        var_dump($response->getBody()->getContents());
        exit;
        dd($response->getBody());
    }

    public static function actionIndex()
    {
        return '51ym';
    }

}