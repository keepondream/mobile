<!DOCTYPE HTML>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="renderer" content="webkit|ie-comp|ie-stand">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" />
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <!--[if lt IE 9]>
    <script type="text/javascript" src="{{ asset('lib/html5shiv.js') }}"></script>
    <script type="text/javascript" src="{{ asset('lib/respond.min.js') }}"></script>
    <![endif]-->
    <link rel="stylesheet" type="text/css" href="{{ asset('static/h-ui/css/H-ui.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('css/jquery.slider.css') }}" />
    <link rel="stylesheet" type="text/css" href="lib/Hui-iconfont/1.0.8/iconfont.min.css" />
    <!--[if lt IE 9]>
    <link href="{{ asset('static/h-ui/css/H-ui.ie.css') }}" rel="stylesheet" type="text/css" />
    <![endif]-->
    <!--[if IE 6]>
    <script type="text/javascript" src="{{ asset('lib/DD_belatedPNG_0.0.8a-min.js') }}" ></script>
    <script>DD_belatedPNG.fix('*');</script>
    <![endif]-->
    <style type="text/css">
        .ui-sortable .panel-header{ cursor:move}
    </style>
    <title>{{ config('app.name', 'Laravel') }}</title>
    {{--<meta name="keywords" content="关键词,5个左右,单个8汉字以内">--}}
    {{--<meta name="description" content="网站描述，字数尽量空制在80个汉字，160个字符以内！">--}}
</head>
<body ontouchstart>
<div class="sideBox">
    <ul class="nav navbar-nav pt-20">
        <li><a href="about.html">登录/注册</a></li>
        <li><a href="jiansuo.html">技术检索</a></li>
        <li><a href="about.html">关于我们</a></li>
        <li><a href="#">联系我们</a></li>
        <li><a href="#">隐私保护</a></li>
        <li><a href="#">免责声明</a></li>
        <li><a href="#">支付方式</a></li>
    </ul>
</div>
<div class="containBox">
    <div class="containBox-bg"></div>
    <header class="navbar-wrapper">
        <div class="navbar navbar-black navbar-fixed-top">
            <div class="container cl">
                <a class="logo navbar-logo hidden-xs" href="/aboutHui.shtml">{{ config('app.name', 'Laravel') }}</a>
                <a class="logo navbar-logo-m visible-xs" href="/aboutHui.shtml">{{ config('app.name', 'Laravel') }}</a>
                <span class="logo navbar-slogan hidden-xs">方便 &middot; 贴心 &middot; 中国网站</span>
                <a aria-hidden="false" class="nav-toggle Hui-iconfont visible-xs JS-nav-toggle" href="javascript:;">&#xe667;</a>
                <nav class="nav navbar-nav nav-collapse" role="navigation" id="Hui-navbar">
                    <ul class="cl">
                        <li class="current">
                            <a href="{{route('home')}}">首页</a>
                        </li>
                        <li>
                            <a href="http://www.h-ui.net/Hui-overview.shtml" target="_blank">核心</a>
                        </li>
                        <li>
                            <a href="http://www.h-ui.net/lib/jQuery.cookie.js.shtml" target="_blank">脚本</a>
                        </li>
                        <li class="dropDown dropDown_hover">
                            <a href="javascript:;" class="dropDown_A">工具 <i class="Hui-iconfont">&#xe6d5;</i></a>
                            <ul class="dropDown-menu menu radius box-shadow">
                                <li>
                                    <a href="http://www.h-ui.net/bug.shtml" target="_blank">Bug兼容性汇总</a>
                                </li>
                                <li>
                                    <a href="http://www.h-ui.net/websafecolors.shtml" target="_blank">web安全色</a>
                                </li>
                                <li>
                                    <a href="http://www.h-ui.net/Hui-3.7-Hui-iconfont.shtml" target="_blank">Hui-iconfont</a>
                                </li>
                                <li>
                                    <a href="javascript:;">web工具箱<i class="arrow Hui-iconfont">&#xe6d7;</i></a>
                                    <ul class="menu">
                                        <li>
                                            <a href="http://www.h-ui.net/tools/jsformat.shtml" target="_blank">JS/HTML格式化工具</a>
                                        <li>
                                            <a href="http://www.h-ui.net/tools/HTMLtoJS.shtml" target="_blank">HTML/JS转换工具</a>
                                        <li>
                                            <a href="http://www.h-ui.net/tools/cssformat.shtml" target="_blank">CSS代码格式化工具</a>
                                        <li>
                                            <a href="http://www.h-ui.net/tools/daxiaoxie.shtml" target="_blank">字母大小写转换工具</a>
                                        <li>
                                            <a href="http://www.h-ui.net/tools/fantizhuanhuan.shtml" target="_blank">繁体字、火星文转换</a>
                                        <li>
                                            <a href="javascript:;">三级菜单<i class="arrow Hui-iconfont">&#xe6d7;</i></a>
                                            <ul class="menu">
                                                <li>
                                                    <a href="javascript:;">四级菜单</a>
                                                </li>
                                                <li>
                                                    <a href="javascript:;">四级菜单</a>
                                                </li>
                                                <li>
                                                    <a href="javascript:;">四级菜单</a>
                                                </li>
                                            </ul>
                                        </li>
                                        <li>
                                            <a href="#">三级导航</a>
                                        </li>
                                    </ul>
                                </li>
                                <li>
                                    <a href="#">二级导航</a>
                                </li>
                                <li class="disabled">
                                    <a href="javascript:;">二级菜单</a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="http://h-ui.net/aboutHui.shtml" target="_blank">联系我们</a>
                        </li>
                        @if (Route::has('login'))
                                @auth
                                <li class="dropDown dropDown_hover f-r">
                                    <a href="#" class="dropDown_A">{{ Auth::user()->name }} <i class="Hui-iconfont">&#xe6d5;</i></a>
                                    <ul class="dropDown-menu menu radius box-shadow">
                                        <li><a href="javascript:;" onClick="myselfinfo()">个人信息</a></li>
                                        {{--<li><a href="#">切换账户</a></li>--}}
                                        <li><a href="{{ route('logout') }}">{{__('退出')}}</a></li>
                                    </ul>
                                </li>
                                @else
                                <li class="f-r">
                                    <a href="javascript:;" onclick="modaldemo()">{{ __('注册') }}</a>
                                </li>
                                <li class="f-r">
                                    <a href="javascript:;" onclick="modaldemo(1)">{{ __('登录') }}</a>
                                </li>
                                @endauth
                        @endif

                    </ul>
                </nav>
                <nav class="navbar-userbar hidden-xs"></nav>
            </div>
        </div>
    </header>
    <div class="wap-container">
        @yield('scroll')
        @yield('content')
        <footer class="footer mt-20">
            <div class="container">
                <nav class="footer-nav">
                    <a target="_blank" href="http://www.h-ui.net/aboutHui.shtml">关于H-ui</a>
                    <span class="pipe">|</span>
                    <a target="_blank" href="http://www.h-ui.net/copyright.shtml">软件著作权</a>
                    <span class="pipe">|</span>
                    <a target="_blank" href="http://www.h-ui.net/juanzeng.shtml">感谢捐赠</a>
                </nav>
                <p>Copyright &copy;2013-2017 H-ui.net All Rights Reserved. <br>
                    <a rel="nofollow" target="_blank" href="http://www.miitbeian.gov.cn/">京ICP备15015336号-1</a>
                    <br>
                    未经允许，禁止转载、抄袭、镜像<br>
                    用心做站，做不一样的站</p>
            </div>
        </footer>
    </div>
</div>
<!--普通弹出层-->
<div id="modal-demo" class="modal fade middle" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('register') }}" method="post" class="form form-horizontal responsive" id="demoform">
        <div class="modal-content radius">
            <div class="modal-header">
                <h3 class="modal-title" style="text-align: center;" id="registerTitle">注册</h3>
                <a class="close btn btn-default radius" data-dismiss="modal" aria-hidden="true" href="javascript:;">×</a>
            </div>
            <div class="modal-body">
                <div class="panel-body" id="registerDiv" style="padding: 0;">
                        <div class="row cl">
                            <input type="hidden" name="checkAuth" value="">
                            @csrf
                            <label class="form-label col-xs-3">用户名</label>
                            <div class="formControls col-xs-8">
                                <input type="text" class="input-text" placeholder="4~16个字符，字母/中文/数字/下划线" name="name" id="name">
                            </div>
                        </div>
                        <div class="row cl" id="registerDivPwd">
                            <label class="form-label col-xs-3">密码</label>
                            <div class="formControls col-xs-8">
                                <input type="password" class="input-text" autocomplete="off" placeholder="请输入密码" name="password" id="password">
                            </div>
                        </div>
                        <div class="row cl" id="registerDivPwd2">
                            <label class="form-label col-xs-3">确认密码</label>
                            <div class="formControls col-xs-8">
                                <input type="password" class="input-text" autocomplete="off" placeholder="请输入确认密码" name="password_confirmation" id="password_confirmation">
                            </div>
                        </div>
                        <div class="row cl">
                            <label class="form-label col-xs-3">
                            </label>
                            <div class="formControls col-xs-8">
                                <div id="slider2" class="slider"></div>
                            </div>
                        </div>
                </div>
            </div>
            <div class="modal-footer" style="text-align: center">
                <button class="btn btn-success size-L" id="registerDivSubmit">立即注册</button>
            </div>
        </div>
        </form>

    </div>
</div>
<script type="text/javascript" src="{{ asset('lib/jquery/1.9.1/jquery.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('lib/jquery-ui/1.9.1/jquery-ui.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('static/h-ui/js/H-ui.js') }}"></script>
<script type="text/javascript" src="{{ asset('lib/jquery.SuperSlide/2.1.1/jquery.SuperSlide.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('lib/jquery.validation/1.14.0/jquery.validate.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('lib/jquery.validation/1.14.0/validate-methods.js') }}"></script>
<script type="text/javascript" src="{{ asset('lib/jquery.validation/1.14.0/messages_zh.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/jquery.slider.min.js') }}"></script>

<script>
    var _token = $("meta[name='csrf-token']").attr('content');
    //弹窗
    function modaldemo(status){
        $("#slider2").slider("restore");
        $("input[name='checkAuth']").val('');
        if (status == 1){
            var url = '{{ route('login') }}';
            $('#demoform').attr('action',url);
            $("#registerTitle").html('登录');
            $('#registerDivPwd2').remove();
            $('#registerDivSubmit').html('登录');
        } else {
            var url = '{{ route('register') }}';
            $('#demoform').attr('action',url);
            $("#registerTitle").html('注册');
            $('#registerDivSubmit').html('立即注册');
            if (!$('#registerDivPwd2').length) {
                var pasdiv = "<div class=\"row cl\" id=\"registerDivPwd2\"><label class=\"form-label col-xs-3\">确认密码</label><div class=\"formControls col-xs-8\"><input type=\"password\" class=\"input-text\" autocomplete=\"off\" placeholder=\"请输入确认密码\" name=\"password_confirmation\" id=\"password2\"></div></div>";
                $("#registerDivPwd").after(pasdiv);
            }
        }
        $("#modal-demo").modal("show");
    }
    //消息框
    function modalalertdemo(msg){
        $.Huimodalalert(msg,2000);
    }
    $(function(){
        $(".input-text,.textarea").Huifocusblur();

        //幻灯片
        jQuery("#slider-3 .slider").slide({mainCell:".bd ul",titCell:".hd li",trigger:"click",effect:"leftLoop",autoPlay:true,delayTime:700,interTime:3000,pnLoop:false,titOnClassName:"active"});

        $(".panel").Huifold({
            titCell:'.panel-header',
            mainCell:'.panel-body',
            type:1,
            trigger:'click',
            className:"selected",
            speed:"first",
        });

        //邮箱提示
        $("#email").emailsuggest();

        //checkbox 美化
        $('.skin-minimal input').iCheck({
            checkboxClass: 'icheckbox-blue',
            radioClass: 'iradio-blue',
            increaseArea: '20%'
        });

        //日期插件
        $("#datetimepicker").datetimepicker({
            format: 'yyyy-mm-dd',
            minView: "month",
            todayBtn:  1,
            autoclose: 1,
            endDate : new Date()
        }).on('hide',function(e) {
            //此处可以触发日期校验。
        });

        /*+1 -1效果*/
        $("#spinner-demo").Huispinner({
            value:1,
            minValue:1,
            maxValue:99,
            dis:1
        });

        $(".textarea").Huitextarealength({
            minlength:10,
            maxlength:200.
        });

        $("#demoform").validate({
            rules:{
                name:{
                    required:true,
                    minlength:2,
                    maxlength:16
                },
                password:{
                    required:true,
                    rangelength:[6,16]
                },
                password_confirmation:{
                    required:true,
                    equalTo: "#password"
                },
            },
            onkeyup:false,
            focusCleanup:true,
            success:"valid",
            submitHandler:function(form){
                if ($('input[name="checkAuth"]').val() == ''){
                    modalalertdemo('请滑动验证!~');
                    return false;
                }
                //验证用户名是否存在
                var name = $('input[name="name"]').val();
                var pwd2 = $('#registerDivPwd2').length;
                if (name && pwd2) {
                    var status = 1;
                        $.ajax({
                        type: 'POST',
                        url: '{{route('checkMember')}}',
                        data:{name:name,_token:_token},
                        dataType: 'json',
                        async: false,
                        success: function(data){
                            if (data.code != 200) {
                                modalalertdemo('此用户名已经存在!~');
                                status = 2;
                            }
                        }
                    });
                    if (status == 2) {
                        return false;
                    }
                }
                return true;
                // $(form).ajaxSubmit();

            }
        });

        //选项卡
        $("#HuiTab-demo1").Huitab({
            index:0
        });

        $("#Huitags-demo1").Huitags();

        //返回顶部
        $.Huitotop();

        //hover效果
        $('.maskWraper').Huihover();

        //星级评价
        $("#star-1").raty({
            hints: ['1','2', '3', '4', '5'],//自定义分数
            starOff: 'iconpic-star-S-default.png',//默认灰色星星
            starOn: 'iconpic-star-S.png',//黄色星星
            path: 'static/h-ui/images/star',//可以是相对路径
            number: 5,//星星数量，要和hints数组对应
            showHalf: true,
            targetKeep : true,
            click: function (score, evt) {//点击事件
                //第一种方式：直接取值
                $("#result-1").html('你的评分是'+score+'分');
            }
        });

        $( ".ui-sortable" ).sortable({
            //connectWith: ".panel",
            items:".panel",
            handle: ".panel-header",
            //delay: 300, //时间延迟
            //distance: 15, //距离延迟
            placeholder: "ui-state-highlight", //占位符样式
            update: function(event, ui){

            }
        }).disableSelection();

        var _bodyHeight = $(window).height();
        var _doch = $(document).height();
        $(".containBox").height(_bodyHeight);

        /*左右滑动菜单*/
        $(".JS-nav-toggle").click(function() {
            $("body").addClass('sideBox-open');
            $(".containBox-bg").height(_bodyHeight).show();
        });
        $(".containBox-bg").click(function() {
            $(this).hide();
            $("body").removeClass('sideBox-open');
        });

        //滑动验证
        $("#slider2").slider({
            width: 340, // width
            height: 40, // height
            sliderBg: "rgb(134, 134, 131)", // 滑块背景颜色
            color: "#fff", // 文字颜色
            fontSize: 14, // 文字大小
            bgColor: "#33CC00", // 背景颜色
            textMsg: "按住滑块，拖拽验证", // 提示文字
            successMsg: "验证通过", // 验证成功提示文字
            successColor: "red", // 滑块验证成功提示文字颜色
            time: 400, // 返回时间
            callback: function(result) { // 回调函数，true(成功),false(失败)
                if (result) {
                    $('input[name="checkAuth"]').val('1');
                } else {
                    $('input[name="checkAuth"]').val('');
                }
            }
        });
    });
</script>
@yield('script')
</body>
</html>


