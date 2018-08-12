<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class Swoole extends Command
{
    public $ws;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'swoole {action?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'swoole description';

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
        //
        $action = $this->argument('action');
        switch ($action) {
            case 'close':
                break;
            default:
                $this->start();
                break;
        }
    }

    public function start()
    {
        //创建 websocket 服务对象 ,监听 0.0.0.0:8888
        $this->ws = new \Swoole\WebSocket\Server("0.0.0.0",8888);

        //监听 websocket 连接时间
        $this->ws->on('open', function ($ws, $request) {
           var_dump($request->fd . "连接成功");
        });

        //监听 websocket 消息事件
        $this->ws->on('message', function ($ws, $frame) {
             echo "Message: {$frame->data}\n";
            // $ws->push($frame->fd, "server: {$frame->data}");
            // var_dump($ws->connection_info($frame->fd));
            //fd 绑定客户端传过来的标识 uid
            $ws->bind($frame->fd, $frame->data);

        });

        $this->ws->on('request', function ($request, $response) {
            //接收 http 请求 post 获取参数
            //获取所有连接的客户端, 验证 uid 给指定用户推送消息
            //token 验证推送来源,避免恶意访问
            if ($request->post['token'] == '') {
                $clients = $this->ws->getClientList();
                $clientId = [];
                foreach ($clients as $value) {
                    $clientInfo = $this->ws->connection_info($value);
                    if (array_key_exists('uid',$clientInfo) && $clientInfo['uid'] == $request->post['s_id']) {
                        $clientId[] = $value;
                    }
                }
                if (!empty($clientId)) {
                    foreach ($clientId as $v) {
                        $this->ws->push($v,$request->post['info']);
                    }
                }
            }
        });

        //监听 websocket 连接关闭
        $this->ws->on('close', function ($ws, $fd) {
           echo "client:{$fd} is closed\n";
        });

        $this->ws->start();

    }
}
