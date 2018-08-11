<?php

namespace App\Console\Commands;

use App\Libraries\Sms51ym\Sms51ym;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Redis;

class SmsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    //此处代表laravel自动生成的名称，下面执行的时候能用到
    protected $signature = 'smsmobile';

    /**
     * The console command description.
     *
     * @var string
     */
    //此处代表的是描述，并没有什么用的
    protected $description = '定时检查sms redis 任务';

    /**
     * 自己增加的
     * 计算数据服务的 service 属性
     *这里由于要用到我们的逻辑，所以提前定义一下，方便下面使用
     * @var CalculateDataService
     */
    protected $service;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    //这个是laravel自带的构造方法。初始状态下是空的。
    //我这里由于要调用CalculateDataService 类的一个方法，所有就用依赖注入的方式引入了一下。
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    /**
     * Execute the console command.
     *这里就是我们执行操作的地方，里面是command要处理的业务。根据我们的需求，
     *调用类中的calculateData（）方法，该方法是我们自己的需求逻辑部分。
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
                    case 'yimagetmobile':
                        //易码平台获取手机号失败,再次获取,如若失败会再次获取,最大获取60次 后直接终止入库
                        $model = new Sms51ym();
                        $model::getMobile($param['type'],$param['memberid'],$param['orderid'],$param['num'],$param['data'],$param['repetition']);
                        var_dump($param);
                        break;
                    case 'maizigetmobile':
                        break;
                    default:
                        echo "黑洞!".PHP_EOL;
                        break;
                }
            } else {
                echo "没有数据".PHP_EOL;
            }
//            //每三秒执行一次
//            for ($i=1;$i<=20;$i++){
//                sleep(2);
//            }
        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }
        //  line()方法是command类中自带的方法，可以输出我们自定义的信息
//        $this->line('calculate Data Success!');

    }
}
