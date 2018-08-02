<?php

namespace App\Http\Controllers;

use App\Common\Common;
use App\http\Model\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->middleware('auth');
    }

    /**
     * 产品功能页
     * @return \Illuminate\Http\Response
     */
    public function product()
    {

        dd(1231);
        return view('home');
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
    public function getisp(Request $request)
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
}
