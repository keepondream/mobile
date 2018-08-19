<?php

namespace App\Http\Controllers;

use App\http\Model\Category;
use App\Http\Model\Site;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public $category = '';      //获取导航分类

    public $siteinfo = '';      //系统基础信息

    public function __construct()
    {
        $this->category = Category::where('status',1)->orderBy('sort','ASC')->orderBy('id','ASC')->get();
        $this->siteinfo = Site::find(1);
    }

}


