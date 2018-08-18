<?php

namespace App\Console\Commands;

use App\http\Model\MobileLog;
use App\Libraries\Sms51ym\Sms51ym;
use Illuminate\Console\Command;

class Sms extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sms';

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
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function handle()
    {
        try {
            //查询库里面 手机号获取成功 且 未获取短信内容的数据
            $data = MobileLog::where(['mobile_status'=> 1,'is_sms'=>0])->orderBy('id','asc')->get()->toArray();
            if (count($data) > 0) {
                foreach ($data as $sms) {
                    //根据不同的平台进行不同平台的接口调用
                    if ($sms['brand_type'] == 'yima') {
                        $model = new Sms51ym();
                        $res = $model::getSms($sms);
                        if (!empty($res)) {
                            if ($res['code'] != 200) {
                                $this->line($res['msg'].$sms['id']);
                            } else {
                                $this->line($res['msg'].$sms['id']);
                            }
                        }
                    } elseif ($sms['brand_type'] == 'maizi') {
                        $this->line('麦子接口');
                    }
                }
            }
        } catch (\Exception $exception) {
            $this->error($exception->getMessage());
        }

        $this->line('--------');
    }
}
