<?php

namespace App\Console\Commands;

use App\http\Model\MobileLog;
use App\User;
use Illuminate\Console\Command;

class SmsBackCredit extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'credit';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '返回获取短信内容失败的用户积分';

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
            //查询短信获取失败
            $data = MobileLog::where(['mobile_status'=>1,'is_sms'=>2,'is_credit_return'=>0])->orderBy('id','asc')->get();
            if (count($data) > 0) {
                foreach ($data as $datum) {
                    $model = User::find($datum->user_id);
                    $model->credit = $model->credit + 10; //_____________-此处默认一条10分 后期更改------
                    if ($model->save()) {
                        $datum->is_credit_return = 1;
                        $datum->save();
                    }
                }
            }
        } catch (\Exception $exception) {
            $this->error($exception->getMessage());
        }
    }
}
