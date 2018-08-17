<?php

namespace App\Http\Controllers;

use App\Common\Common;
use App\http\Model\Brand;
use App\http\Model\MobileLog;
use App\http\Model\Project;
use App\Libraries\Sms51ym\Sms51ym;
use App\Libraries\Smsmaizi\Smsmaizi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;

class HomeController extends Controller
{
    /**
     * HomeController constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->middleware('auth');
    }

    /**
     * 收码功能页
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function code(Request $request)
    {
        $data['categorys'] = $this->category;//导航
        $data['categoryUrl'] = 'code';//当前导航url
        $data['user'] = Auth::user();
        //Redis::set('sms51ymtoken','111','EX',10);  //指定过期时间
        $data['brandval'] = Redis::get(md5('code'.Auth::id().'brandval'));
        $data['itemidval'] = Redis::get(md5('code'.Auth::id().'itemidval'));
        $data['phonenumval'] = Redis::get(md5('code'.Auth::id().'phonenumval'));
        $data['ispval'] = Redis::get(md5('code'.Auth::id().'ispval'));
        $data['provinceval'] = Redis::get(md5('code'.Auth::id().'provinceval'));
        $data['cityval'] = Redis::get(md5('code'.Auth::id().'cityval'));
        $data['excludenoval'] = Redis::get(md5('code'.Auth::id().'excludenoval'));

        $data['brand'] = Brand::where('status','1')->orderBy('sort','ASC')->orderBy('id','ASC')->get();
        //获取最近的消费记录
        $data['model'] = MobileLog::where('user_id',Auth::id())->orderBy('get_mobile_time','desc')->limit(20)->get();
        return view('code',$data);

    }

    /**
     * 获取平台对应的运营商
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getISP(Request $request)
    {
        $param = Common::dataCheck($request->input());
        $msg = Common::jsonOutData(201,'非法请求!~');
        if (!empty($param['sign'])) {
            $isp = Common::isp($param['sign']);
            if (!empty($isp)) {
                $msg = Common::jsonOutData(200,'success',compact('isp'));
            }
        }
        return response()->json($msg);
    }

    /**
     * 选择城市 jquery 动态获取
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCitySelect(Request $request)
    {
        $param = Common::dataCheck($request->input());
        $parent_id = $param['parent_id'];
        $data= Region::where('parent_id',$parent_id)->select(['code','name'])->get()->toArray();

        $msg = Common::jsonOutData(200,'ok',$data);
        return response()->json($msg);
    }

    /**
     * 获取对应平台下的可用项目
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getProject(Request $request)
    {
        $param = Common::dataCheck($request->input());
        $msg = Common::jsonOutData(201,'非法请求!~');
        if (!empty($param['sign'])) {
            $brand = Brand::where('sign',$param['sign'])->select(['id'])->get();
            if (count($brand) > 0) {
                $projects = $brand[0]->projects;
                if (count($projects) > 0) {
                    $msg = Common::jsonOutData(200,'ok',$projects);
                }
            }
        }
        return response()->json($msg);
    }

    /**
     * 获取手机号码 进行扣分 入库 错误处理
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getMobile(Request $request)
    {
        $param = Common::dataCheck($request->input());
        //根据平台调用不同的接口
        empty($param['brandsign']) && $msg = Common::jsonOutData(201,'请选择正确的品牌!');
        empty($param['itemid']) && $msg = Common::jsonOutData(201,'请选择正确的项目!');
        empty($param['phonenum']) && $msg = Common::jsonOutData(201,'请输入获取数量,最大数量为10条!');
        //设置选择品牌
        Redis::set(md5('code'.Auth::id().'brandval'),$param['brandsign'],'EX',86400);
        Redis::set(md5('code'.Auth::id().'itemidval'),$param['itemid'],'EX',86400);
        Redis::set(md5('code'.Auth::id().'phonenumval'),$param['phonenum'],'EX',86400);

        // 获取调用平台
        $brandsign = $param['brandsign'];
        unset($param['brandsign']);
        if ($brandsign == 'yima') {
            //易码平台操作
            if (!empty($msg)) {
                return response()->json($msg);
            }

            #获取总数量
            $phonenum = $param['phonenum'];
            unset($param['phonenum']);

            //验证当前用户积分是否够获取手机号数量; ---------------------
            $credit = intval(Auth::user()->credit);
//            $credit = (int)'';
            if (($credit - ($phonenum * 10)) < 0) {
                $msg = Common::jsonOutData(201,'您的可用积分不足!,请联系管理充值.');
//                $outdata = [
//                    'order_id' => 'A812443854903979',
//                    'num' => '3'
//                ];
//                $msg = Common::jsonOutData(200,'正在拼命加载中....请您稍作等待!',$outdata);
                return response()->json($msg);
            }
            //获取并删除多余参数
            # isp 运营商
            if (isset($param['isp']) && empty($param['isp'])) {
                Redis::set(md5('code'.Auth::id().'ispval'),'','EX',86400);
                unset($param['isp']);
            } else {
                Redis::set(md5('code'.Auth::id().'ispval'),$param['isp'],'EX',86400);
            }
            # province 省
            if (isset($param['province']) && empty($param['province'])) {
                Redis::set(md5('code'.Auth::id().'provinceval'),'','EX',86400);
                unset($param['province']);
            } else {
                Redis::set(md5('code'.Auth::id().'provinceval'),$param['province'],'EX',86400);
            }
            # city 市
            if (isset($param['city']) && empty($param['city'])) {
                Redis::set(md5('code'.Auth::id().'cityval'),'','EX',86400);
                unset($param['city']);
            } else {
                Redis::set(md5('code'.Auth::id().'cityval'),$param['city'],'EX',86400);
            }
            # 指定号码
            if (isset($param['mobile']) && empty($param['mobile'])) {
                unset($param['mobile']);
                $phonenum = 1;
            }
            # 验证排除号的合法性
            $excludenoStr = '';
            if (!empty($param['excludeno'])) {
                $excludenoArr = explode('.',$param['excludeno']);
                foreach ($excludenoArr as $v) {
                    if (strlen($v) == 3) {
                        if (!empty($excludenoStr)) {
                            $excludenoStr .= '.'.$v;
                        } else {
                            $excludenoStr = $v;
                        }
                    }
                }
            }
            if (!empty($excludenoStr)) {
                $param['excludeno'] = $excludenoStr;
                Redis::set(md5('code'.Auth::id().'excludenoval'),$param['excludeno'],'EX',86400);

            } else {
                Redis::set(md5('code'.Auth::id().'excludenoval'),'','EX',86400);
                unset($param['excludeno']);
            }

            if (!empty($phonenum) && $phonenum > 0) {
                //生成唯一订单号获取手机号
                $order_id = Common::orderSn();
                $model = new Sms51ym();
                for ($i = 0 ; $i < $phonenum; $i++) {
                    //编辑平台操作标识
                    ## 在此方法里面手机号获取成功后应立即扣除相应积分
                    $model::getMobile($brandsign,Auth::user()->id,$order_id,$phonenum,$param);
                    //如果获取多条,每条等待2秒
//                    sleep(2);
                }
                //组装 订单ID 并返回 在客户端 进行手机号数据调用
                $outdata = [
                    'order_id' => $order_id,
                    'num' => $phonenum
                ];
                $msg = Common::jsonOutData(200,'正在拼命加载中....请您稍作等待!',$outdata);
            }

        } elseif ($brandsign == 'maizi') {
            //麦子平台操作

            //实例化麦子类
            $apiModel = new Smsmaizi();

        } else {
            $msg = Common::jsonOutData(201,'品牌暂未开放');
        }



        return response()->json($msg);

    }

    /**
     * 获取所有订单信息
     */
    public function getAllMobildDetail(Request $request)
    {
        $param = Common::dataCheck($request->input());
        if ($request->isMethod('post')) {
            if (!empty($param['order_id'])) {
                $outdata = MobileLog::where('order_id',$param['order_id'])->orderBy('id','asc')->get()->toArray();
                //组装数据
                $count = count($outdata);
                $data['count'] = $count;
                $clear = 1;
                if ($count > 0) {
                    foreach ($outdata as $v) {
                        $tempArr = [];
                        //根据订单状态组装数据 短信内容区间
                        if ($v['is_sms'] == 1) {
                            $tempArr['content'] = '短信内容获取成功!';
                            $tempArr['class'] = 'success';
                            $tempArr['status'] = 1;     //最终状态 1 已使用 0 未使用
                        } elseif ($v['is_sms'] == 2) {
                            $tempArr['content'] = '短信获取失败!,所耗积分将30分钟内返还.';
                            $tempArr['class'] = 'danger';
                            $tempArr['status'] = 1;
                        } else {
                            //手机号码区间
                            if ($v['mobile_status'] == 1) {
                                $temptime = $v['get_mobile_time'] + 300;
                                $tempArr['content'] = '手机号获取成功!将于 '.date('H:i:s',$temptime).' 后自动释放,请及时使用.';
                                $tempArr['class'] = 'warning';
                                $tempArr['status'] = 0;
                                $clear = 0;
                            } elseif ($v['mobile_status'] == 2) {
                                $tempArr['content'] = '手机号获取失败!不会消耗积分!';
                                $tempArr['class'] = 'danger';
                                $tempArr['status'] = 0;
                                $clear = 0;
                            }
                        }
                        $tempArr['mobile'] = $v['mobile'];
                        $tempArr['sms_content'] = $v['sms_content'];
                        $tempArr['id'] = $v['id'];
                        $tempArr['isblock'] = $v['is_block'];
                        $data['content'][] = $tempArr;
                    }
                }
                $data['clear'] = $clear;
                $data['credit'] = Auth::user()->credit;
                $msg = Common::jsonOutData(200,'ok',$data);
                return response()->json($msg);
            }
        }
    }

    /**
     * 手机号码拉黑 进Redis
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function mobileBlock(Request $request)
    {
        $param = Common::dataCheck($request->input());
        $msg = Common::jsonOutData(201,'拉黑失败!~');
        if ($request->isMethod('post')) {
            if (!empty($param['id'])) {
                Redis::Rpush(md5('mobileBlock'),$param['id']);
                $msg = Common::jsonOutData(200,'拉黑成功!');
            }
        }

        return response()->json($msg);
    }
}


