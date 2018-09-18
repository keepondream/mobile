<?php

namespace App\Console\Commands;

use App\Libraries\Sms51ym\Sms51ym;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Redis;

class GetSmsTwo extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'smstwo';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '获取短信内容';

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
            //获取队列中的数据
            $res = Redis::lpop(md5('smstwo'));
            if (!empty($res)) {
                $param = json_decode($res, true);
                //根据对应平台类型进行数据处理
                switch ($param['brand_type']) {
                    case 'yima':
                        //易码
                        $model = new Sms51ym();
                        $res = $model::getSms($param);
                        if (!empty($res)) {
                            if ($res['code'] != 200) {
                                $this->line($res['msg'].$param['id']);
                            } else {
                                $this->line($res['msg'].$param['id']);
                            }
                        }
                        break;
                    case 'maizi':
                        //麦子
                        break;
                    default:
                        echo "未知的类型平台!~".PHP_EOL;
                        break;
                }
            }
        } catch (\Exception $exception) {
            $this->error($exception->getMessage());
        }
    }
}
