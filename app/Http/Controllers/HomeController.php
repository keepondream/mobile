<?php

namespace App\Http\Controllers;

use App\Common\Common;
use App\http\Model\Brand;
use App\http\Model\Project;
use App\Libraries\Sms51ym\Sms51ym;
use App\Libraries\Smsmaizi\Smsmaizi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $data['brand'] = Brand::where('status','1')->orderBy('sort','ASC')->orderBy('id','ASC')->get();
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

    public function getMobile(Request $request)
    {
        /*[
          "brandsign" => "yima"
          "itemid" => "7732"
          "isp" => "3"
          "province" => "110000"
          "city" => "110100"
          "excludeno" => "171.186"
          "phonenum" => "5"
        ]*/
        $param = Common::dataCheck($request->input());
        //根据平台调用不同的接口
        empty($param['brandsign']) && $msg = Common::jsonOutData(201,'请选择正确的品牌!');
        empty($param['itemid']) && $msg = Common::jsonOutData(201,'请选择正确的项目!');
        empty($param['phonenum']) && $msg = Common::jsonOutData(201,'请输入获取数量,最大数量为10条!');
        // 获取调用平台
        $brandsign = $param['brandsign'];
        unset($param['brandsign']);
        if ($brandsign == 'yima') {
            //易码平台操作

            //获取并删除多余参数
            # isp 运营商
            if (isset($param['isp']) && empty($param['isp'])) {
                unset($param['isp']);
            }
            # province 省
            if (isset($param['province']) && empty($param['province'])) {
                unset($param['province']);
            }
            # city 市
            if (isset($param['city']) && empty($param['city'])) {
                unset($param['city']);
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
            } else {
                unset($param['excludeno']);
            }
            #获取总数量
            $phonenum = $param['phonenum'];
            unset($param['phonenum']);
            if (!empty($phonenum) && $phonenum > 0) {
                //生成唯一订单号获取手机号
                $order_id = Common::orderSn();
                //验证当前用户积分是否够获取手机号数量;
                //目前先定制1积分获取依次
                if (Auth::user()->credit > $phonenum) {
                    $model = new Sms51ym();
                    for ($i = 0 ; $i < $phonenum; $i++) {
                        //编辑平台操作标识
                        $type = $brandsign.'getmobile';
                        $res = $model::getMobile($type,Auth::user()->id,$order_id,$phonenum,$param);
                        dd($res);
                    }
                }
            }







        } elseif ($brandsign == 'maizi') {
            //麦子平台操作

            //实例化麦子类
            $apiModel = new Smsmaizi();

        } else {
            $msg = Common::jsonOutData(201,'品牌暂未开放');
        }

    }
}
