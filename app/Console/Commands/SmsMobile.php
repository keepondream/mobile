<?php

namespace App\Console\Commands;

use App\Libraries\Sms51ym\Sms51ym;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Redis;


class SmsMobile extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'smsmobile';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '获取手机号';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        try {
            //获取Redis中的失败获取手机号操作
            $res = Redis::lpop(md5('mobile'));
            if (!empty($res)) {
                $param = json_decode($res,true);
                //根据不同的类型处理不同的事情   所有Redis 监听进程都在此处  3秒钟 执行一次
                switch ($param['type']) {
                    case 'yima':
                        //易码平台获取手机号失败,再次获取,如若失败会再次获取,最大获取60次 后直接终止入库
                        $model = new Sms51ym();
                        $model::getMobile($param['type'],$param['memberid'],$param['orderid'],$param['num'],$param['data'],$param['repetition']);
                        break;
                    case 'maizi':
                        break;
                    default:
                        echo "黑洞!".PHP_EOL;
                        break;
                }
            } else {
                $this->line('没有手机号需要222获取');
            }
        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }
    }
}
