<?php

namespace App\Console\Commands;

use App\http\Model\MobileLog;
use App\Libraries\Sms51ym\Sms51ym;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Redis;
use function PHPSTORM_META\type;

class SmsMobileBlock extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mobileblock';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '检测拉黑手机号码进行拉黑操作';

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
            //获取拉黑手机号的ID
            $id = Redis::lpop(md5('mobileBlock'));
            if (!empty($id)) {
                $modelMobile = MobileLog::find($id);
                if (!empty($modelMobile->id)) {
                    //根据不同的类型处理不同的事情   所有Redis 监听进程都在此处  3秒钟 执行一次
                    switch ($modelMobile->brand_type) {
                        case 'yima':
                            //易码平台获取手机号失败,再次获取,如若失败会再次获取,最大获取60次 后直接终止入库
                            $model = new Sms51ym();
                            $modelMobile->is_block = $model::addignore($modelMobile->itemid,$modelMobile->mobile);
                            $modelMobile->save();
                            $this->line('拉黑成功!~'.$modelMobile->id);
                            break;
                        case 'maizi':
                            break;
                        default:
                            echo "黑洞!".PHP_EOL;
                            break;
                    }
                }
            } else {
                $this->line('没有需要拉黑数据');
            }
        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }
    }
}
