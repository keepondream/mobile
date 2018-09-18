<?php

namespace App\Console;

use App\Console\Commands\GetSmsOne;
use App\Console\Commands\GetSmsThree;
use App\Console\Commands\GetSmsTwo;
use App\Console\Commands\Sms;
use App\Console\Commands\SmsBackCredit;
use App\Console\Commands\SmsMobile;
use App\Console\Commands\SmsMobileBlock;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     * 注：此处是引入我们新创建的类。
     * @var array
     */
    protected $commands = [
        Sms::class,
        SmsMobile::class,
        SmsBackCredit::class,
        SmsMobileBlock::class,
        GetSmsOne::class,
        GetSmsTwo::class,
        GetSmsThree::class
    ];

    /**
     * Define the application's command schedule.
     * 注：
     * 1、这个方法按照自己的需求，确定定时方法的执行顺序。通过after，before等关键词来控制
     * 2、此处相当于规定同意的定时执行时间，如都在0:30分执行下面的几个定时任务
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        //示例
//        // 每天凌晨 0.45 执行同步 aliyun 数据的任务，并发送邮件给 ***
//        $schedule->command('iot:sync Flow')
//            ->after(function() {
//                //更新偏移量,after里面不能加参数
//                Artisan::call('Test:data');
//            })
//            ->after(function () {
//                // 执行同步数据命令完成后 则执行计算数据任务
//                Artisan::call('calculate:data');
//            });

        // $schedule->command('inspire')
        //          ->hourly();

        # 执行手机号获取失败后的 循环获取程序,并入口记录 成功自动扣分
        $schedule->command('smsmobile')
            ->everyMinute()
            ->sendOutputTo('./crontab.log');

        $schedule->command('smsmobiletwo')
            ->everyMinute()
            ->sendOutputTo('./crontabtwo.log');

        $schedule->command('smsmobilethree')
            ->everyMinute()
            ->sendOutputTo('./crontabthree.log');

        # 获取短信 最新改动 利用 redis 取代 sms 查库方式 2018-09-18 15:23:49
        $schedule->command('smsone')
            ->everyMinute()
            ->sendOutputTo('./smscrontab.log');
        $schedule->command('smstwo')
            ->everyMinute()
            ->sendOutputTo('./smscrontab.log');
        $schedule->command('smsthree')
            ->everyMinute()
            ->sendOutputTo('./smscrontab.log');
//            ->appendOutputTo('./smscrontab.log');
        # 返回积分
        $schedule->command('credit')
            ->everyMinute()
            ->sendOutputTo('./smsbackcreditcrontab.log');
//            ->appendOutputTo('./smsbackcreditcrontab.log');
        # 手机号拉黑
        $schedule->command('mobileBlock')
            ->everyMinute()
            ->sendOutputTo('./smsmobileblockcrontab.log');
    }

    /**
     * Register the commands for the application.
     * //这个部分是laravel自动生成的，引入我们生成的命令文件
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
