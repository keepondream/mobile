<?php
/*
 *
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Route::get('/', function () {
//    return view('welcome');
//});

//前台用户验证
Auth::routes();
//前台首页
Route::get('/', 'WelecomeController@index')->name('home');
Route::post('/checkMember','WelecomeController@checkMember')->name('checkMember');
Route::get('/home', 'HomeController@product')->name('product');
Route::get('checklogin','WelecomeController@checklogin')->name('checklogin');

//非法路劲跳转前台启动登录
Route::get('/jump','WelecomeController@jump')->name('jump');

Route::group(['middleware'=>'auth'], function () {
    Route::any('code','HomeController@code')->name('code');
    Route::post('getISP','HomeController@getISP')->name('getisp');
    Route::post('getProject','HomeController@getProject')->name('getProject');
    Route::post('getCitySelect','HomeController@getCitySelect')->name('getCitySelect');
    Route::post('getMobile','HomeController@getMobile')->name('getMobile');
});







//后台路由 中间件检测
Route::group(['prefix' => 'admin','namespace'=>'Admin'], function () {
    //辅助数据填充
    Route::get('assistInitOnlyOwn','HomeController@assist');

    //操作权限验证
    Route::post('checkAuth','HomeController@checkAuth')->name('checkAuth');

    //登录
    Route::get('login','LoginController@index');
    Route::post('login','LoginController@login')->name('adminlogin');
    Route::get('loginOut','LoginController@loginOut')->name('adminloginout');

    //首页
    Route::get('/', 'HomeController@index')->name('admin')->middleware('adminCheck');     //检测登录状态是否过期

    //我的桌面
    Route::get('welcome','HomeController@welcome')->name('Awelcome');



    //系统管理
    Route::get('set','SiteController@set')->name('set');

    //菜单管理
    Route::any('menu','SiteController@menu')->name('menu');
    Route::any('menuAdd','SiteController@menuAdd')->name('menuAdd');
    Route::post('menuDel','SiteController@menuDel')->name('menuDel');


    //管理员管理
    //角色
    Route::get('role','MangerController@role')->name('role');
    Route::any('roleAdd','MangerController@roleAdd')->name('roleAdd');
    Route::any('roleDel','MangerController@roleDel')->name('roleDel');


    //权限
    Route::any('access','MangerController@access')->name('access');
    Route::any('accessAdd','MangerController@accessAdd')->name('accessAdd');
    Route::post('accessDel','MangerController@accessDel')->name('accessDel');

    //管理员列表
    Route::any('manager','MangerController@manager')->name('manager');
    Route::any('managerAdd','MangerController@managerAdd')->name('managerAdd');
    Route::post('managerDel','MangerController@managerDel')->name('managerDel');
    Route::post('managerStatus','MangerController@managerStatus')->name('managerStatus');

    //会员管理
    Route::any('member','MemberController@member')->name('member');
    Route::any('memberAdd','MemberController@memberAdd')->name('memberAdd');
    Route::post('memberDel','MemberController@memberDel')->name('memberDel');
    Route::post('memberStatus','MemberController@memberStatus')->name('memberStatus');
    Route::any('changePassword','MemberController@changePassword')->name('changePassword');

    //城市选择
    Route::post('citySelect','MemberController@citySelect')->name('citySelect');

    //产品管理
    Route::any('product','ProductController@category')->name('category');
    Route::any('productCategoryAdd','ProductController@categoryAdd')->name('categoryAdd');
    Route::post('productCategoryDel','ProductController@categoryDel')->name('categoryDel');
    Route::any('paas','ProductController@paas')->name('paas');
    Route::any('paasAdd','ProductController@paasAdd')->name('paasAdd');
    Route::post('paasDel','ProductController@paasDel')->name('paasDel');
    Route::post('passStatus','ProductController@passStatus')->name('passStatus');
    Route::any('project','ProductController@project')->name('project');
    Route::any('projectAdd','ProductController@projectAdd')->name('projectAdd');
    Route::post('projectDel','ProductController@projectDel')->name('projectDel');
    Route::post('projectStatus','ProductController@projectStatus')->name('projectStatus');



    //订单管理
});

