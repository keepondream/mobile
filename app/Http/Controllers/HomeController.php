<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
        return view('code',$data);

    }
}
