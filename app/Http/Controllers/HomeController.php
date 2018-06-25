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
}
