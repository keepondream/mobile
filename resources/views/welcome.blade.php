@extends('layouts.app')
@section('scroll')
    <style>
        #slider-1{width:100%;text-align:center;height: 280px;}
        #slider-1 .bd,#slider-1 .bd li,#slider-1 .bd img{width:100%; height:220px}
        #slider-1 .hd{ margin-top:2px;height:58px;width:100%;}
        #slider-1 .hd li{ position:relative; display:inline-block; float:left; margin-right:2px;cursor:pointer;width:16%; height:58px}
        #slider-1 .hd li img{ display:block;width:100%; height:58px}
        #slider-1 .hd li i{ position:absolute; display:block; z-index:9; left:0; top:0; right:0; bottom:0; background-color:rgba(0,0,0,0.6)}
        #slider-1 .hd li.active i{ width:11px; height:6px; background:url({{ asset('temp/scroll/iconpic-arrow-up.png') }}) no-repeat 0 0; top:-6px; left:50%; margin-left:-5px; bottom:auto; right:auto}
    </style>
    <div id="slider-1" class="bg-fff box-shadow radius">
        <div class="slider">
            <div class="bd bg-fff">
                <ul>
                    <li><a href="#" target="_blank"><img src="{{ asset('temp/scroll/b-1.jpg') }}" ></a></li>
                    <li><a href="#" target="_blank"><img src="{{ asset('temp/scroll/b-2.jpg') }}" ></a></li>
                    <li><a href="#" target="_blank"><img src="{{ asset('temp/scroll/b-3.jpg') }}" ></a></li>
                    <li><a href="#" target="_blank"><img src="{{ asset('temp/scroll/b-4.jpg') }}" ></a></li>
                    <li><a href="#" target="_blank"><img src="{{ asset('temp/scroll/b-5.jpg') }}" ></a></li>
                    <li><a href="#" target="_blank"><img src="{{ asset('temp/scroll/b-6.jpg') }}" ></a></li>
                </ul>
            </div>
            <ol class="hd cl" style="bottom: -60px;">
                <li><i></i><img src="{{ asset('temp/scroll/s-1.jpg') }}"></li>
                <li><i></i><img src="{{ asset('temp/scroll/s-2.jpg') }}"></li>
                <li><i></i><img src="{{ asset('temp/scroll/s-3.jpg') }}"></li>
                <li><i></i><img src="{{ asset('temp/scroll/s-4.jpg') }}"></li>
                <li><i></i><img src="{{ asset('temp/scroll/s-5.jpg') }}"></li>
                <li><i></i><img src="{{ asset('temp/scroll/s-6.jpg') }}"></li>
            </ol>
        </div>
    </div>
@endsection
@section('content')
        {{--<nav class="breadcrumb">--}}
            {{--<div class="container">--}}
                {{--<i class="Hui-iconfont">&#xe67f;</i>--}}
                {{--<a href="/" class="c-primary">首页</a>--}}
                {{--<span class="c-gray en">&gt;</span>--}}
                {{--<a href="#">组件</a>--}}
                {{--<span class="c-gray en">&gt;</span>--}}
                {{--<span class="c-gray">当前页面</span>--}}
            {{--</div>--}}
        {{--</nav>--}}
        {{--<div class="container ui-sortable">--}}
            {{--<h1>Hi,H-ui!</h1>--}}
            {{--<p>开始前端之旅！</p>--}}
            {{--<div class="panel panel-default">--}}
                {{--<div class="panel-header">表单</div>--}}
                {{--<div class="panel-body">--}}
                    {{--<form action="" method="post" class="form form-horizontal responsive" id="demoform">--}}
                        {{--<div class="row cl">--}}
                            {{--<label class="form-label col-xs-3">邮箱：</label>--}}
                            {{--<div class="formControls col-xs-8">--}}
                                {{--<input type="text" class="input-text" placeholder="@" name="email" id="email" autocomplete="off">--}}
                            {{--</div>--}}
                        {{--</div>--}}
                        {{--<div class="row cl">--}}
                            {{--<label class="form-label col-xs-3">用户名：</label>--}}
                            {{--<div class="formControls col-xs-8">--}}
                                {{--<input type="text" class="input-text" placeholder="4~16个字符，字母/中文/数字/下划线" name="username" id="username">--}}
                            {{--</div>--}}
                        {{--</div>--}}
                        {{--<div class="row cl">--}}
                            {{--<label class="form-label col-xs-3">手机：</label>--}}
                            {{--<div class="formControls col-xs-8">--}}
                                {{--<input type="text" class="input-text" autocomplete="off" placeholder="手机" name="telephone" id="telephone">--}}
                            {{--</div>--}}
                        {{--</div>--}}
                        {{--<div class="row cl">--}}
                            {{--<label class="form-label col-xs-3">密码：</label>--}}
                            {{--<div class="formControls col-xs-8">--}}
                                {{--<input type="password" class="input-text" autocomplete="off" placeholder="密码" name="password" id="password">--}}
                            {{--</div>--}}
                        {{--</div>--}}
                        {{--<div class="row cl">--}}
                            {{--<label class="form-label col-xs-3">密码验证：</label>--}}
                            {{--<div class="formControls col-xs-8">--}}
                                {{--<input type="password" class="input-text" autocomplete="off" placeholder="密码" name="password2" id="password2">--}}
                            {{--</div>--}}
                        {{--</div>--}}
                        {{--<div class="row cl">--}}
                            {{--<label class="form-label col-xs-3">单选框：</label>--}}
                            {{--<div class="formControls skin-minimal col-xs-5">--}}
                                {{--<div class="radio-box">--}}
                                    {{--<input type="radio" id="sex-1" name="sex">--}}
                                    {{--<label for="sex-1">男</label>--}}
                                {{--</div>--}}
                                {{--<div class="radio-box">--}}
                                    {{--<input type="radio" id="sex-2" name="sex">--}}
                                    {{--<label for="sex-2">女</label>--}}
                                {{--</div>--}}
                                {{--<div class="radio-box">--}}
                                    {{--<input type="radio" id="sex-3" name="sex">--}}
                                    {{--<label for="sex-3">保密</label>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                        {{--<div class="row cl">--}}
                            {{--<label class="form-label col-xs-3">出生日期：</label>--}}
                            {{--<div class="formControls col-xs-8">--}}
                                {{--<input type="text" class="input-text" value="" autocomplete="off" id="datetimepicker" name="datetimepicker">--}}
                            {{--</div>--}}
                        {{--</div>--}}
                        {{--<div class="row cl">--}}
                            {{--<label class="form-label col-xs-3">爱好：</label>--}}
                            {{--<div class="formControls skin-minimal col-xs-5">--}}
                                {{--<div class="check-box">--}}
                                    {{--<input type="checkbox" id="checkbox-5" name="checkbox2">--}}
                                    {{--<label for="checkbox-5">上网</label>--}}
                                {{--</div>--}}
                                {{--<div class="check-box">--}}
                                    {{--<input type="checkbox" id="checkbox-6" name="checkbox2">--}}
                                    {{--<label for="checkbox-6">摄影</label>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                        {{--<div class="row cl">--}}
                            {{--<label class="form-label col-xs-3">数量：</label>--}}
                            {{--<div class="formControls skin-minimal col-xs-5">--}}
                                {{--<div id="spinner-demo"></div>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                        {{--<div class="row cl">--}}
                            {{--<label class="form-label col-xs-3">附件：</label>--}}
                            {{--<div class="formControls col-xs-8">--}}
								{{--<span class="btn-upload form-group">--}}
								{{--<input class="input-text upload-url" type="text" name="uploadfile-2" id="uploadfile-2" readonly style="width:200px">--}}
								{{--<a href="javascript:void();" class="btn btn-primary upload-btn"><i class="Hui-iconfont">&#xe642;</i> 浏览文件</a>--}}
								{{--<input type="file" multiple name="file-2" class="input-file">--}}
								{{--</span>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                        {{--<div class="row clearfix">--}}
                            {{--<label class="form-label col-xs-3">所在城市：</label>--}}
                            {{--<div class="formControls col-xs-8">--}}
                                {{--<div class="row clearfix" style="margin-top:0">--}}
                                    {{--<div class="col-xs-6">--}}
										{{--<span class="select-box">--}}
											{{--<select class="select" size="1" name="city">--}}
												{{--<option value="" selected>选择省份</option>--}}
												{{--<option value="1">北京</option>--}}
												{{--<option value="2">上海</option>--}}
												{{--<option value="3">广州</option>--}}
											{{--</select>--}}
										{{--</span>--}}
                                    {{--</div>--}}
                                    {{--<div class="col-xs-6">--}}
										{{--<span class="select-box">--}}
											{{--<select class="select" size="1" name="city">--}}
												{{--<option value="" selected>选择城市</option>--}}
												{{--<option value="1">北京</option>--}}
												{{--<option value="2">上海</option>--}}
												{{--<option value="3">广州</option>--}}
											{{--</select>--}}
										{{--</span>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                        {{--<div class="row cl">--}}
                            {{--<label class="form-label col-xs-3">网址：</label>--}}
                            {{--<div class="formControls col-xs-8">--}}
                                {{--<input type="text" class="input-text" placeholder="http://" name="website" id="website">--}}
                            {{--</div>--}}
                        {{--</div>--}}
                        {{--<div class="row cl">--}}
                            {{--<label class="form-label col-xs-3">备注：</label>--}}
                            {{--<div class="formControls col-xs-8">--}}
                                {{--<textarea cols="" rows="" class="textarea" name="beizhu" id="beizhu"  placeholder="说点什么...最少输入10个字符"></textarea>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                        {{--<div class="row cl">--}}
                            {{--<div class="col-xs-8 col-xs-offset-3">--}}
                                {{--<input class="btn btn-primary" type="submit" value="&nbsp;&nbsp;提交&nbsp;&nbsp;">--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--</form>--}}
                {{--</div>--}}
            {{--</div>--}}
            {{--<div class="panel panel-default mt-20">--}}
                {{--<div class="panel-header">按钮</div>--}}
                {{--<div class="panel-body">--}}
                    {{--<table class="table table-border table-bordered table-striped table-responsive mt-20">--}}
                        {{--<thead>--}}
                        {{--<tr>--}}
                            {{--<th class="col1">button</th>--}}
                            {{--<th class="col2">input</th>--}}
                            {{--<th class="col3">a</th>--}}
                            {{--<th class="col4">disabled状态</th>--}}
                            {{--<th class="col5">空心</th>--}}
                        {{--</tr>--}}
                        {{--</thead>--}}
                        {{--<tbody>--}}
                        {{--<tr>--}}
                            {{--<td><button class="btn btn-default radius" type="button">默认</button></td>--}}
                            {{--<td><input class="btn btn-default radius" type="button" value="默认"></td>--}}
                            {{--<td><a href="#" class="btn btn-default radius">默认</a></td>--}}
                            {{--<td><input class="btn btn-default radius disabled" type="button" value="不可点击"></td>--}}
                            {{--<td></td>--}}
                        {{--</tr>--}}
                        {{--<tr>--}}
                            {{--<td><button class="btn btn-primary radius" type="button">主要</button></td>--}}
                            {{--<td><input class="btn btn-primary radius" type="button" value="主要"></td>--}}
                            {{--<td><a href="#" class="btn btn-primary radius">主要</a></td>--}}
                            {{--<td><input class="btn btn-primary radius disabled" type="button" value="不可点击"></td>--}}
                            {{--<td><input class="btn btn-primary-outline radius" type="button" value="主要"></td>--}}
                        {{--</tr>--}}
                        {{--<tr>--}}
                            {{--<td><button class="btn btn-secondary radius" type="button">次要</button></td>--}}
                            {{--<td><input class="btn btn-secondary radius" type="button" value="次要"></td>--}}
                            {{--<td><a href="#" class="btn btn-secondary radius">次要</a></td>--}}
                            {{--<td><input class="btn btn-secondary radius disabled" type="button" value="不可点击"></td>--}}
                            {{--<td><input class="btn radius btn-secondary-outline radius" type="button" value="次要"></td>--}}
                        {{--</tr>--}}
                        {{--<tr>--}}
                            {{--<td><button class="btn btn-success radius" type="button">成功</button></td>--}}
                            {{--<td><input class="btn btn-success radius" type="button" value="成功"></td>--}}
                            {{--<td><a href="#" class="btn btn-success radius">成功</a></td>--}}
                            {{--<td><input class="btn btn-success radius disabled" type="button" value="不可点击"></td>--}}
                            {{--<td><input class="btn btn-success-outline radius" type="button" value="成功"></td>--}}
                        {{--</tr>--}}
                        {{--<tr>--}}
                            {{--<td><button class="btn btn-warning radius" type="button">警告</button></td>--}}
                            {{--<td><input class="btn btn-warning radius" type="button" value="警告"></td>--}}
                            {{--<td><a href="#" class="btn btn-warning radius">警告</a></td>--}}
                            {{--<td><input class="btn btn-warning radius disabled" type="button" value="不可点击"></td>--}}
                            {{--<td><input class="btn btn-warning-outline radius" type="button" value="警告"></td>--}}
                        {{--</tr>--}}
                        {{--<tr>--}}
                            {{--<td><button class="btn btn-danger radius" type="button">危险</button></td>--}}
                            {{--<td><input class="btn btn-danger radius" type="button" value="危险"></td>--}}
                            {{--<td><a href="#" class="btn btn-danger radius">危险</a></td>--}}
                            {{--<td><input class="btn btn-danger radius disabled" type="button" value="不可点击"></td>--}}
                            {{--<td><input class="btn btn-danger-outline radius" type="button" value="危险"></td>--}}
                        {{--</tr>--}}
                        {{--<tr>--}}
                            {{--<td><button class="btn btn-link radius" type="button">链接</button></td>--}}
                            {{--<td><input class="btn btn-link radius" type="button" value="链接"></td>--}}
                            {{--<td><a href="#" class="btn btn-link radius">链接</a></td>--}}
                            {{--<td><input class="btn btn-link radius disabled" type="button" value="不可点击"></td>--}}
                            {{--<td></td>--}}
                        {{--</tr>--}}
                        {{--</tbody>--}}
                    {{--</table>--}}
                    {{--<h3>按钮大小</h3>--}}
                    {{--<table class="table table-border table-bordered table-striped">--}}
                        {{--<thead>--}}
                        {{--<tr>--}}
                            {{--<th width="30%">按钮</th>--}}
                            {{--<th>class=""</th>--}}
                        {{--</tr>--}}
                        {{--</thead>--}}
                        {{--<tbody>--}}
                        {{--<tr>--}}
                            {{--<td><input type="button" class="btn btn-primary size-XL radius" value="特大按钮"></td>--}}
                            {{--<td><code>size-XL</code></td>--}}
                        {{--</tr>--}}
                        {{--<tr>--}}
                            {{--<td><input type="button" class="btn btn-primary size-L radius" value="大按钮"></td>--}}
                            {{--<td><code>size-L</code></td>--}}
                        {{--</tr>--}}
                        {{--<tr>--}}
                            {{--<td><input type="button" class="btn btn-primary radius" value="默认尺寸"></td>--}}
                            {{--<td><code>size-M</code> 缺省值</td>--}}
                        {{--</tr>--}}
                        {{--<tr>--}}
                            {{--<td><input type="button" class="btn btn-primary size-S radius" value="小按钮"></td>--}}
                            {{--<td><code>size-S</code></td>--}}
                        {{--</tr>--}}
                        {{--<tr>--}}
                            {{--<td><input type="button" class="btn btn-primary size-MINI radius" value="迷你按钮"></td>--}}
                            {{--<td><code>size-MINI</code></td>--}}
                        {{--</tr>--}}
                        {{--</tbody>--}}
                    {{--</table>--}}
                    {{--<h3>按钮组</h3>--}}
                    {{--<div class="btn-group">--}}
                        {{--<span class="btn btn-primary radius">左边按钮</span>--}}
                        {{--<span class="btn btn-default radius">中间按钮</span>--}}
                        {{--<span class="btn btn-default radius">中间按钮</span>--}}
                        {{--<span class="btn btn-default radius">右边按钮</span>--}}
                    {{--</div>--}}
                    {{--<div class="cl mt-20">--}}
                        {{--<div class="btn-group l">--}}
                            {{--<span class="btn btn-primary" title="源代码"><i class="Hui-iconfont">&#xe6ee;</i></span>--}}
                        {{--</div>--}}
                        {{--<div class="btn-group l ml-5">--}}
                            {{--<span class="btn btn-primary" title="左对齐"><i class="Hui-iconfont">&#xe710;</i></span>--}}
                            {{--<span class="btn btn-primary" title="居中对齐"><i class="Hui-iconfont">&#xe70e;</i></span>--}}
                            {{--<span class="btn btn-primary" title="右对齐"><i class="Hui-iconfont">&#xe711;</i></span>--}}
                            {{--<span class="btn btn-primary" title="两头对齐"><i class="Hui-iconfont">&#xe70f;</i></span>--}}
                        {{--</div>--}}
                        {{--<div class="btn-group l ml-5">--}}
                            {{--<span class="btn btn-primary" title="字体"><i class="Hui-iconfont">&#xe6ec;</i></span>--}}
                            {{--<span class="btn btn-primary" title="加粗"><i class="Hui-iconfont">&#xe6e7;</i></span>--}}
                            {{--<span class="btn btn-primary" title="倾斜"><i class="Hui-iconfont">&#xe6e9;</i></span>--}}
                            {{--<span class="btn btn-primary" title="下划线"><i class="Hui-iconfont">&#xe6fe;</i></span>--}}
                            {{--<span class="btn btn-primary" title="行高"><i class="Hui-iconfont">&#xe6fc;</i></span>--}}
                            {{--<span class="btn btn-primary" title="行宽"><i class="Hui-iconfont">&#xe6fd;</i></span>--}}
                        {{--</div>--}}
                        {{--<div class="btn-group l ml-5">--}}
                            {{--<span class="btn btn-primary" title="链接"><i class="Hui-iconfont">&#xe6f1;</i></span>--}}
                            {{--<span class="btn btn-primary" title="有序列表"><i class="Hui-iconfont">&#xe6f3;</i></span>--}}
                            {{--<span class="btn btn-primary" title="无序列表"><i class="Hui-iconfont">&#xe6f5;</i></span>--}}
                        {{--</div>--}}
                        {{--<div class="btn-group l ml-5">--}}
                            {{--<span class="btn btn-primary" title="剪切"><i class="Hui-iconfont">&#xe6ef;</i></span>--}}
                            {{--<span class="btn btn-primary" title="复制"><i class="Hui-iconfont">&#xe6ea;</i></span>--}}
                            {{--<span class="btn btn-primary" title="粘贴"><i class="Hui-iconfont">&#xe6eb;</i></span>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}
            {{--<div class="panel panel-default mt-20">--}}
                {{--<div class="panel-header">图片</div>--}}
                {{--<div class="panel-body">--}}
                    {{--<p><img width="140" height="140" src="data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiIHN0YW5kYWxvbmU9InllcyI/PjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB3aWR0aD0iMTQwIiBoZWlnaHQ9IjE0MCIgdmlld0JveD0iMCAwIDE0MCAxNDAiIHByZXNlcnZlQXNwZWN0UmF0aW89Im5vbmUiPjwhLS0KU291cmNlIFVSTDogaG9sZGVyLmpzLzE0MHgxNDAKQ3JlYXRlZCB3aXRoIEhvbGRlci5qcyAyLjYuMC4KTGVhcm4gbW9yZSBhdCBodHRwOi8vaG9sZGVyanMuY29tCihjKSAyMDEyLTIwMTUgSXZhbiBNYWxvcGluc2t5IC0gaHR0cDovL2ltc2t5LmNvCi0tPjxkZWZzPjxzdHlsZSB0eXBlPSJ0ZXh0L2NzcyI+PCFbQ0RBVEFbI2hvbGRlcl8xNTEwYmJhZjQzYSB0ZXh0IHsgZmlsbDojQUFBQUFBO2ZvbnQtd2VpZ2h0OmJvbGQ7Zm9udC1mYW1pbHk6QXJpYWwsIEhlbHZldGljYSwgT3BlbiBTYW5zLCBzYW5zLXNlcmlmLCBtb25vc3BhY2U7Zm9udC1zaXplOjEwcHQgfSBdXT48L3N0eWxlPjwvZGVmcz48ZyBpZD0iaG9sZGVyXzE1MTBiYmFmNDNhIj48cmVjdCB3aWR0aD0iMTQwIiBoZWlnaHQ9IjE0MCIgZmlsbD0iI0VFRUVFRSIvPjxnPjx0ZXh0IHg9IjQ0LjA1NDY4NzUiIHk9Ijc0LjUiPjE0MHgxNDA8L3RleHQ+PC9nPjwvZz48L3N2Zz4=" alt="..." class="radius">--}}
                        {{--<img width="140" height="140" src="data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiIHN0YW5kYWxvbmU9InllcyI/PjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB3aWR0aD0iMTQwIiBoZWlnaHQ9IjE0MCIgdmlld0JveD0iMCAwIDE0MCAxNDAiIHByZXNlcnZlQXNwZWN0UmF0aW89Im5vbmUiPjwhLS0KU291cmNlIFVSTDogaG9sZGVyLmpzLzE0MHgxNDAKQ3JlYXRlZCB3aXRoIEhvbGRlci5qcyAyLjYuMC4KTGVhcm4gbW9yZSBhdCBodHRwOi8vaG9sZGVyanMuY29tCihjKSAyMDEyLTIwMTUgSXZhbiBNYWxvcGluc2t5IC0gaHR0cDovL2ltc2t5LmNvCi0tPjxkZWZzPjxzdHlsZSB0eXBlPSJ0ZXh0L2NzcyI+PCFbQ0RBVEFbI2hvbGRlcl8xNTEwYmJhZjQzYSB0ZXh0IHsgZmlsbDojQUFBQUFBO2ZvbnQtd2VpZ2h0OmJvbGQ7Zm9udC1mYW1pbHk6QXJpYWwsIEhlbHZldGljYSwgT3BlbiBTYW5zLCBzYW5zLXNlcmlmLCBtb25vc3BhY2U7Zm9udC1zaXplOjEwcHQgfSBdXT48L3N0eWxlPjwvZGVmcz48ZyBpZD0iaG9sZGVyXzE1MTBiYmFmNDNhIj48cmVjdCB3aWR0aD0iMTQwIiBoZWlnaHQ9IjE0MCIgZmlsbD0iI0VFRUVFRSIvPjxnPjx0ZXh0IHg9IjQ0LjA1NDY4NzUiIHk9Ijc0LjUiPjE0MHgxNDA8L3RleHQ+PC9nPjwvZz48L3N2Zz4=" alt="..." class="round">--}}
                        {{--<img style="width:140px; height:140px" src="data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiIHN0YW5kYWxvbmU9InllcyI/PjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB3aWR0aD0iMTQwIiBoZWlnaHQ9IjE0MCIgdmlld0JveD0iMCAwIDE0MCAxNDAiIHByZXNlcnZlQXNwZWN0UmF0aW89Im5vbmUiPjwhLS0KU291cmNlIFVSTDogaG9sZGVyLmpzLzE0MHgxNDAKQ3JlYXRlZCB3aXRoIEhvbGRlci5qcyAyLjYuMC4KTGVhcm4gbW9yZSBhdCBodHRwOi8vaG9sZGVyanMuY29tCihjKSAyMDEyLTIwMTUgSXZhbiBNYWxvcGluc2t5IC0gaHR0cDovL2ltc2t5LmNvCi0tPjxkZWZzPjxzdHlsZSB0eXBlPSJ0ZXh0L2NzcyI+PCFbQ0RBVEFbI2hvbGRlcl8xNTEwYmJhZjQzYSB0ZXh0IHsgZmlsbDojQUFBQUFBO2ZvbnQtd2VpZ2h0OmJvbGQ7Zm9udC1mYW1pbHk6QXJpYWwsIEhlbHZldGljYSwgT3BlbiBTYW5zLCBzYW5zLXNlcmlmLCBtb25vc3BhY2U7Zm9udC1zaXplOjEwcHQgfSBdXT48L3N0eWxlPjwvZGVmcz48ZyBpZD0iaG9sZGVyXzE1MTBiYmFmNDNhIj48cmVjdCB3aWR0aD0iMTQwIiBoZWlnaHQ9IjE0MCIgZmlsbD0iI0VFRUVFRSIvPjxnPjx0ZXh0IHg9IjQ0LjA1NDY4NzUiIHk9Ijc0LjUiPjE0MHgxNDA8L3RleHQ+PC9nPjwvZz48L3N2Zz4=" alt="..." class="thumbnail"></p>--}}
                    {{--<div class="album-item" style="width:200px">--}}
                        {{--<div class="album-img">--}}
                            {{--<img src="data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiIHN0YW5kYWxvbmU9InllcyI/PjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB3aWR0aD0iMTQwIiBoZWlnaHQ9IjE0MCIgdmlld0JveD0iMCAwIDE0MCAxNDAiIHByZXNlcnZlQXNwZWN0UmF0aW89Im5vbmUiPjwhLS0KU291cmNlIFVSTDogaG9sZGVyLmpzLzE0MHgxNDAKQ3JlYXRlZCB3aXRoIEhvbGRlci5qcyAyLjYuMC4KTGVhcm4gbW9yZSBhdCBodHRwOi8vaG9sZGVyanMuY29tCihjKSAyMDEyLTIwMTUgSXZhbiBNYWxvcGluc2t5IC0gaHR0cDovL2ltc2t5LmNvCi0tPjxkZWZzPjxzdHlsZSB0eXBlPSJ0ZXh0L2NzcyI+PCFbQ0RBVEFbI2hvbGRlcl8xNTEwYmJhZjQzYSB0ZXh0IHsgZmlsbDojQUFBQUFBO2ZvbnQtd2VpZ2h0OmJvbGQ7Zm9udC1mYW1pbHk6QXJpYWwsIEhlbHZldGljYSwgT3BlbiBTYW5zLCBzYW5zLXNlcmlmLCBtb25vc3BhY2U7Zm9udC1zaXplOjEwcHQgfSBdXT48L3N0eWxlPjwvZGVmcz48ZyBpZD0iaG9sZGVyXzE1MTBiYmFmNDNhIj48cmVjdCB3aWR0aD0iMTQwIiBoZWlnaHQ9IjE0MCIgZmlsbD0iI0VFRUVFRSIvPjxnPjx0ZXh0IHg9IjQ0LjA1NDY4NzUiIHk9Ijc0LjUiPjE0MHgxNDA8L3RleHQ+PC9nPjwvZz48L3N2Zz4=">--}}
                        {{--</div>--}}
                        {{--<div class="album-title">《仙剑奇侠传》赵灵儿--}}
                            {{--<span class="c-999">(20张)</span>--}}
                        {{--</div>--}}
                        {{--<div class="album-bg">--}}
                            {{--<div class="album-bg-Fir"></div>--}}
                            {{--<div class="album-bg-Sec"></div>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                    {{--<div>--}}
                        {{--<img src="static/h-ui/images/ucnter/avatar-default.jpg" class="avatar radius size-MINI">--}}
                        {{--<img src="static/h-ui/images/ucnter/avatar-default.jpg" class="avatar radius size-S">--}}
                        {{--<img src="static/h-ui/images/ucnter/avatar-default.jpg" class="avatar radius size-M">--}}
                        {{--<img src="static/h-ui/images/ucnter/avatar-default.jpg" class="avatar radius size-L">--}}
                        {{--<img src="static/h-ui/images/ucnter/avatar-default.jpg" class="avatar radius size-XL">--}}
                    {{--</div>--}}
                    {{--<div class="maskWraper" style="width:300px; height:250px; border:solid 1px #ddd;">--}}
                        {{--<img src="http://images.h-ui.net/www/AD-300x250.gif" width="300" height="250">--}}
                        {{--<div class="maskBar text-c">遮罩条</div>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}
            {{--<div class="panel panel-default mt-20">--}}
                {{--<div class="panel-header">表格</div>--}}
                {{--<div class="panel-body">--}}
                    {{--<table class="table table-border table-bordered table-striped mt-20">--}}
                        {{--<thead>--}}
                        {{--<tr>--}}
                            {{--<th class="col1">表头</th>--}}
                            {{--<th class="col2">表头</th>--}}
                            {{--<th class="col3">表头</th>--}}
                        {{--</tr>--}}
                        {{--</thead>--}}
                        {{--<tbody>--}}
                        {{--<tr>--}}
                            {{--<th class="col1">类别</th>--}}
                            {{--<td class="col2">表格内容</td>--}}
                            {{--<td class="col3">表格内容</td>--}}
                        {{--</tr>--}}
                        {{--<tr>--}}
                            {{--<th class="col1">类别</th>--}}
                            {{--<td class="col2">表格内容</td>--}}
                            {{--<td class="col3">表格内容</td>--}}
                        {{--</tr>--}}
                        {{--<tr>--}}
                            {{--<th class="col1">类别</th>--}}
                            {{--<td class="col2">表格内容</td>--}}
                            {{--<td class="col3">表格内容</td>--}}
                        {{--</tr>--}}
                        {{--</tbody>--}}
                    {{--</table>--}}
                {{--</div>--}}
            {{--</div>--}}
            {{--<div class="panel panel-default mt-20">--}}
                {{--<div class="panel-header">选项卡</div>--}}
                {{--<div class="panel-body">--}}
                    {{--<div id="HuiTab-demo1" class="HuiTab">--}}
                        {{--<div class="tabBar cl">--}}
                            {{--<span>选项卡一</span>--}}
                            {{--<span>选项卡二</span>--}}
                            {{--<span>自适应宽度</span>--}}
                        {{--</div>--}}
                        {{--<div class="tabCon">内容一</div>--}}
                        {{--<div class="tabCon">内容二</div>--}}
                        {{--<div class="tabCon">内容三</div>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}
            {{--<div class="panel panel-default mt-20">--}}
                {{--<div class="panel-header">便签与标号</div>--}}
                {{--<div class="panel-body">--}}
                    {{--<table class="table table-border table-bordered table-bg">--}}
                        {{--<thead>--}}
                        {{--<tr>--}}
                            {{--<th>class=""</th>--}}
                            {{--<th>标签</th>--}}
                            {{--<th>标号</th>--}}
                            {{--<th>描述</th>--}}
                        {{--</tr>--}}
                        {{--</thead>--}}
                        {{--<tbody>--}}
                        {{--<tr>--}}
                            {{--<td><code>label label-default radius</code></td>--}}
                            {{--<td><span class="label label-default radius">默认</span></td>--}}
                            {{--<td><span class="badge badge-default radius">1</span></td>--}}
                            {{--<td>默认</td>--}}
                        {{--</tr>--}}
                        {{--<tr>--}}
                            {{--<td><code>label label-primary radius</code></td>--}}
                            {{--<td><span class="label label-primary radius">主要</span></td>--}}
                            {{--<td><span class="badge badge-primary radius">2</span></td>--}}
                            {{--<td>主要</td>--}}
                        {{--</tr>--}}
                        {{--<tr>--}}
                            {{--<td><code>label label-secondary radius</code></td>--}}
                            {{--<td><span class="label label-secondary radius">次要</span></td>--}}
                            {{--<td><span class="badge badge-secondary radius">3</span></td>--}}
                            {{--<td>次要</td>--}}
                        {{--</tr>--}}
                        {{--<tr>--}}
                            {{--<td><code>label label-success radius</code></td>--}}
                            {{--<td><span class="label label-success radius">成功</span></td>--}}
                            {{--<td><span class="badge badge-success radius">4</span></td>--}}
                            {{--<td>成功</td>--}}
                        {{--</tr>--}}
                        {{--<tr>--}}
                            {{--<td><code>label label-warning radius</code></td>--}}
                            {{--<td><span class="label label-warning radius">警告</span></td>--}}
                            {{--<td><span class="badge badge-warning radius">5</span></td>--}}
                            {{--<td>警告</td>--}}
                        {{--</tr>--}}
                        {{--<tr>--}}
                            {{--<td><code>label label-danger radius</code></td>--}}
                            {{--<td><span class="label label-danger radius">危险</span></td>--}}
                            {{--<td><span class="badge badge-danger radius">6</span></td>--}}
                            {{--<td>危险</td>--}}
                        {{--</tr>--}}
                        {{--</tbody>--}}
                    {{--</table>--}}
                {{--</div>--}}
            {{--</div>--}}
            {{--<div class="panel panel-default mt-20">--}}
                {{--<div class="panel-header">警告</div>--}}
                {{--<div class="panel-body">--}}
                    {{--<div class="Huialert Huialert-success"><i class="Hui-iconfont">&#xe6a6;</i>成功状态提示</div>--}}
                    {{--<div class="Huialert Huialert-danger"><i class="Hui-iconfont">&#xe6a6;</i>危险状态提示</div>--}}
                    {{--<div class="Huialert Huialert-error"><i class="Hui-iconfont">&#xe6a6;</i>错误状态提示</div>--}}
                    {{--<div class="Huialert Huialert-info"><i class="Hui-iconfont">&#xe6a6;</i>信息状态提示</div>--}}
                {{--</div>--}}
            {{--</div>--}}
            {{--<div class="panel panel-default mt-20">--}}
                {{--<div class="panel-header">进度条</div>--}}
                {{--<div class="panel-body">--}}
                    {{--<div class="progress radius">--}}
                        {{--<div class="progress-bar">--}}
                            {{--<span class="sr-only" style="width:25%"></span>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}
            {{--<div class="panel panel-default mt-20">--}}
                {{--<div class="panel-header">弹出窗口</div>--}}
                {{--<div class="panel-body">--}}
                    {{--<p class="mt-20">--}}
                        {{--<button class="btn btn-primary" onClick="modaldemo()">弹出对话框</button>--}}
                        {{--<button class="btn btn-primary ml-20" onClick="modalalertdemo()">消息框，2秒钟自动消失</button>--}}
                    {{--</p>--}}
                {{--</div>--}}
            {{--</div>--}}
            {{--<div class="panel panel-default mt-20">--}}
                {{--<div class="panel-header">分享到</div>--}}
                {{--<div class="panel-body">--}}
                    {{--<section class="share cl">--}}
                        {{--<div class="bdsharebuttonbox Hui-share">--}}
                            {{--<span class="share-text Hui-iconfont">&#xe715;</span>--}}
                            {{--<a href="#" class="bds_weixin Hui-iconfont" data-cmd="weixin" title="分享到微信">&#xe694;</a>--}}
                            {{--<a href="#" class="bds_qzone Hui-iconfont" data-cmd="qzone" title="分享到QQ空间">&#xe6c8;</a>--}}
                            {{--<a href="#" class="bds_sqq Hui-iconfont" data-cmd="sqq" title="分享到QQ好友">&#xe67b;</a>--}}
                            {{--<a href="#" class="bds_tsina Hui-iconfont" data-cmd="tsina" title="分享到新浪微博">&#xe6da;</a>--}}
                            {{--<a href="#" class="bds_tqq Hui-iconfont" data-cmd="tqq" title="分享到腾讯微博">&#xe6d9;</a>--}}
                            {{--<a href="#" class="bds_douban Hui-iconfont" data-cmd="douban" title="分享到豆瓣网">&#xe67c;</a>--}}
                        {{--</div>--}}
                        {{--<script type="text/javascript">--}}
                            {{--window._bd_share_config={--}}
                                {{--"common":{--}}
                                    {{--"bdSnsKey":{},--}}
                                    {{--"bdText":"H-ui前端框架，架起设计与后端的桥梁轻量级前端框架，简单免费，兼容性好，服务中国网站。",--}}
                                    {{--'bdDes':'国内免费轻量级前端框架',--}}
                                    {{--'bdPopTitle':'H-ui前端框架',--}}
                                    {{--"bdMini":"2",--}}
                                    {{--"bdMiniList":false,--}}
                                    {{--"bdPic":"http://static.h-ui.net/h-ui/images/logo-big.jpeg",--}}
                                    {{--"bdStyle":"0",--}}
                                    {{--"bdSize":"24"--}}
                                {{--},--}}
                                {{--"selectShare":{--}}
                                    {{--"bdContainerClass":null,--}}
                                    {{--"bdSelectMiniList":["weixin","qzone","sqq","tsina","tqq","douban"]--}}
                                {{--}--}}
                            {{--};--}}
                            {{--with(document)0[(getElementsByTagName('head')[0]||body).appendChild(createElement('script')).src='http://bdimg.share.baidu.com/static/api/js/share.js?v=89860593.js?cdnversion='+~(-new Date()/36e5)];--}}
                        {{--</script>--}}
                    {{--</section>--}}
                {{--</div>--}}
            {{--</div>--}}
            {{--<div class="panel panel-default mt-20">--}}
                {{--<div class="panel-header">标签</div>--}}
                {{--<div class="panel-body">--}}
                    {{--<div id="Huitags-demo1"></div>--}}
                {{--</div>--}}
            {{--</div>--}}
            {{--<div class="panel panel-default mt-20">--}}
                {{--<div class="panel-header">星星评价</div>--}}
                {{--<div class="panel-body">--}}
                    {{--<div class="clearfix">--}}
                        {{--<span class="f-l f-15 va-m">描述相符：</span>--}}
                        {{--<div id="star-1" class="star-bar size-M f-l mr-10 va-m"></div>--}}
                        {{--<strong id="result-1" class="f-l va-m"></strong>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}
            {{--<div class="panel panel-default mt-20">--}}
                {{--<div class="panel-header">tooltip效果</div>--}}
                {{--<div class="panel-body">--}}
                    {{--<button class="btn btn-primary radius" data-toggle="tooltip" data-placement="right" title="右边显示">右边显示</button>--}}
                    {{--<button class="btn btn-primary radius" data-toggle="tooltip" data-placement="top" title="上边显示">上边显示</button>--}}
                    {{--<button class="btn btn-primary radius" data-toggle="tooltip" data-placement="bottom" title="下边显示">下边显示</button>--}}
                    {{--<button class="btn btn-primary radius" data-toggle="tooltip" data-placement="left" title="左边显示">左边显示</button>--}}
                {{--</div>--}}
            {{--</div>--}}
            {{--<div class="panel panel-default mt-20">--}}
                {{--<div class="panel-header">popover效果</div>--}}
                {{--<div class="panel-body">--}}
                    {{--<button type="button" class="btn btn-primary radius" title="标题" data-container="body" data-toggle="popover" data-placement="left" data-content="左侧的 Popover 中的一些内容">左侧的 Popover</button>--}}
                    {{--<button type="button" class="btn btn-primary radius" title="标题" data-container="body" data-toggle="popover" data-placement="top" data-content="顶部的 Popover 中的一些内容">顶部的 Popover</button>--}}
                    {{--<button type="button" class="btn btn-primary radius" title="标题" data-container="body" data-toggle="popover" data-placement="bottom" data-content="底部的 Popover 中的一些内容">底部的 Popover</button>--}}
                    {{--<button type="button" class="btn btn-primary radius" title="标题" data-container="body" data-toggle="popover" data-placement="right" data-content="右侧的 Popover 中的一些内容">右侧的 Popover</button>--}}
                {{--</div>--}}
            {{--</div>--}}
            {{--<div class="panel panel-default mt-20">--}}
                {{--<div class="panel-header clearfix">--}}
                    {{--<span class="f-l">H-ui官方插件</span>--}}
                    {{--<span class="f-r">需要升级到 H-ui.js v3.1 版本</span>--}}
                {{--</div>--}}
                {{--<div class="panel-body">--}}
                    {{--<table class="table table-border table-bordered table-bg">--}}
                        {{--<thead>--}}
                        {{--<tr>--}}
                            {{--<th width="30%">名称</th>--}}
                            {{--<th width="20%">版本号</th>--}}
                            {{--<th>描述</th>--}}
                        {{--</tr>--}}
                        {{--</thead>--}}
                        {{--<tbody>--}}
                        {{--<tr>--}}
                            {{--<td><a href="http://www.h-ui.net/lib/jQuery.Huihover.js.shtml" target="_blank">jQuery.Huihover.js</a></td>--}}
                            {{--<td>2.0</td>--}}
                            {{--<td>hover</td>--}}
                        {{--</tr>--}}
                        {{--<tr>--}}
                            {{--<td><a href="http://www.h-ui.net/lib/jQuery.Huifocusblur.js.shtml" target="_blank">jQuery.Huifocusblur.js</a></td>--}}
                            {{--<td>2.0</td>--}}
                            {{--<td>得到失去焦点</td>--}}
                        {{--</tr>--}}
                        {{--<tr>--}}
                            {{--<td><a href="http://www.h-ui.net/lib/jQuery.Huifold.js.shtml" target="_blank">jQuery.Huifold.js</a></td>--}}
                            {{--<td>2.0</td>--}}
                            {{--<td>折叠</td>--}}
                        {{--</tr>--}}
                        {{--<tr>--}}
                            {{--<td><a href="http://www.h-ui.net/lib/jQuery.Huipreview.js.shtml" target="_blank">jQuery.Huipreview.js</a></td>--}}
                            {{--<td>2.0</td>--}}
                            {{--<td>图片预览</td>--}}
                        {{--</tr>--}}
                        {{--<tr>--}}
                            {{--<td><a href="http://www.h-ui.net/lib/jQuery.Huispinner.js.shtml" target="_blank">jQuery.Huispinner.js</a></td>--}}
                            {{--<td>2.0</td>--}}
                            {{--<td>微调器</td>--}}
                        {{--</tr>--}}
                        {{--<tr>--}}
                            {{--<td><a href="http://www.h-ui.net/lib/jQuery.Huitab.js.shtml" target="_blank">jQuery.Huitab.js</a></td>--}}
                            {{--<td>2.0</td>--}}
                            {{--<td>选项卡</td>--}}
                        {{--</tr>--}}
                        {{--<tr>--}}
                            {{--<td><a href="http://www.h-ui.net/lib/jQuery.Huitags.js.shtml" target="_blank">jQuery.Huitags.js</a></td>--}}
                            {{--<td>2.0</td>--}}
                            {{--<td>标签</td>--}}
                        {{--</tr>--}}
                        {{--<tr>--}}
                            {{--<td><a href="http://www.h-ui.net/lib/jQuery.Huitextarealength.js.shtml" target="_blank">jQuery.Huitextarealength.js</a></td>--}}
                            {{--<td>2.0</td>--}}
                            {{--<td>字数限制</td>--}}
                        {{--</tr>--}}
                        {{--<tr>--}}
                            {{--<td><a href="http://www.h-ui.net/lib/jQuery.HuitogglePassword.js.shtml" target="_blank">jQuery.HuitogglePassword.js</a></td>--}}
                            {{--<td>2.0</td>--}}
                            {{--<td>隐藏显示密码</td>--}}
                        {{--</tr>--}}
                        {{--<tr>--}}
                            {{--<td><a href="http://www.h-ui.net/lib/jQuery.Huitotop.js.shtml" target="_blank">jQuery.Huitotop.js</a></td>--}}
                            {{--<td>2.0</td>--}}
                            {{--<td>返回顶部</td>--}}
                        {{--</tr>--}}
                        {{--</tbody>--}}
                    {{--</table>--}}
                {{--</div>--}}
            {{--</div>--}}
            {{--<div class="panel panel-default mt-20">--}}
                {{--<div class="panel-header clearfix">--}}
                    {{--<span class="f-l">H-ui.js v3.0 整合的第三方插件<small>(引入了H-ui.js v3.0版本，无需再单独重复引用以下插件)</small></span>--}}
                    {{--<span class="f-r">感谢以下插件！优秀的插件就像金子一样，处处发光</span>--}}
                {{--</div>--}}
                {{--<div class="panel-body">--}}
                    {{--<table class="table table-border table-bordered table-bg">--}}
                        {{--<thead>--}}
                        {{--<tr>--}}
                            {{--<th width="30%">名称</th>--}}
                            {{--<th width="20%">版本号</th>--}}
                            {{--<th>描述</th>--}}
                        {{--</tr>--}}
                        {{--</thead>--}}
                        {{--<tbody>--}}
                        {{--<tr>--}}
                            {{--<td><a href="http://www.h-ui.net/lib/jQuery.cookie.js.shtml" target="_blank">jQuery.cookie.js</a></td>--}}
                            {{--<td>1.4.1</td>--}}
                            {{--<td>jQuery cookie插件。</td>--}}
                        {{--</tr>--}}
                        {{--<tr>--}}
                            {{--<td><a href="http://www.h-ui.net/lib/jQuery.form.js.shtml" target="_blank">jQuery.form.js</a></td>--}}
                            {{--<td>3.51.0</td>--}}
                            {{--<td>jquey表单插件。</td>--}}
                        {{--</tr>--}}
                        {{--<tr>--}}
                            {{--<td><a href="http://www.h-ui.net/lib/jQuery.lazyload.js.shtml" target="_blank">jQuery.lazyload.js</a></td>--}}
                            {{--<td>1.9.3</td>--}}
                            {{--<td>图片的延迟加载插件。</td>--}}
                        {{--</tr>--}}
                        {{--<tr>--}}
                            {{--<td>jQuery.responsive-nav.js</td>--}}
                            {{--<td>1.0.39</td>--}}
                            {{--<td>响应式导航插件。</td>--}}
                        {{--</tr>--}}
                        {{--<tr>--}}
                            {{--<td>jQuery.placeholder.js</td>--}}
                            {{--<td>1.0</td>--}}
                            {{--<td>IE浏览器支持placeholder。</td>--}}
                        {{--</tr>--}}

                        {{--<tr>--}}
                            {{--<td>jQuery.emailsuggest.js</td>--}}
                            {{--<td>1.0</td>--}}
                            {{--<td>邮箱域名自动提示填充插件。</td>--}}
                        {{--</tr>--}}
                        {{--<tr>--}}
                            {{--<td>jQuery.format.js</td>--}}
                            {{--<td>1.0</td>--}}
                            {{--<td>格式化字符串。</td>--}}
                        {{--</tr>--}}

                        {{--<tr>--}}
                            {{--<td>jQuery.iCheck.js</td>--}}
                            {{--<td>1.0</td>--}}
                            {{--<td>单选框，复选框美化插件。</td>--}}
                        {{--</tr>--}}
                        {{--<tr>--}}
                            {{--<td>jQuery.onePageNav.js</td>--}}
                            {{--<td>1.0</td>--}}
                            {{--<td>单页面滚动导航。</td>--}}
                        {{--</tr>--}}
                        {{--<tr>--}}
                            {{--<td>jQuery.stickUp.js</td>--}}
                            {{--<td>1.0</td>--}}
                            {{--<td>网页滚动，元素固定置顶插件。</td>--}}
                        {{--</tr>--}}
                        {{--<tr>--}}
                            {{--<td>jQuery.ColorPicker.js</td>--}}
                            {{--<td>1.0</td>--}}
                            {{--<td>颜色控件。</td>--}}
                        {{--</tr>--}}
                        {{--<tr>--}}
                            {{--<td>Bootstrap.modal.js</td>--}}
                            {{--<td>3.3.0</td>--}}
                            {{--<td>Bootstrap模态窗口，弹窗插件。</td>--}}
                        {{--</tr>--}}
                        {{--<tr>--}}
                            {{--<td>Bootstrap.dropdown.js</td>--}}
                            {{--<td>3.3.0</td>--}}
                            {{--<td>Bootstrap下拉框插件。</td>--}}
                        {{--</tr>--}}
                        {{--<tr>--}}
                            {{--<td>Bootstrap.transition.js</td>--}}
                            {{--<td>3.3.0</td>--}}
                            {{--<td>Bootstrap过渡效果(Transition)插件。</td>--}}
                        {{--</tr>--}}
                        {{--<tr>--}}
                            {{--<td>Bootstrap.tooltip.js</td>--}}
                            {{--<td>3.3.0</td>--}}
                            {{--<td>Bootstrap工具提示插件。</td>--}}
                        {{--</tr>--}}
                        {{--<tr>--}}
                            {{--<td>Bootstrap.popover.js</td>--}}
                            {{--<td>3.3.0</td>--}}
                            {{--<td>Bootstrap弹出框插件。</td>--}}
                        {{--</tr>--}}
                        {{--<tr>--}}
                            {{--<td>Bootstrap.alert.js</td>--}}
                            {{--<td>3.3.0</td>--}}
                            {{--<td>Bootstrap警告框插件。</td>--}}
                        {{--</tr>--}}
                        {{--<tr>--}}
                            {{--<td>Bootstrap.slider.js</td>--}}
                            {{--<td>1.0.1</td>--}}
                            {{--<td>Bootstrap滑动条插件。</td>--}}
                        {{--</tr>--}}
                        {{--<tr>--}}
                            {{--<td>Bootstrap.datetimepicker.js</td>--}}
                            {{--<td>1.0</td>--}}
                            {{--<td>Bootstrap日期插件。</td>--}}
                        {{--</tr>--}}
                        {{--<tr>--}}
                            {{--<td>Bootstrap.Switch.js</td>--}}
                            {{--<td>1.3</td>--}}
                            {{--<td>Bootstrap 开关控件。</td>--}}
                        {{--</tr>--}}
                        {{--</tbody>--}}
                    {{--</table>--}}
                {{--</div>--}}
            {{--</div>--}}

            {{--<div class="panel panel-default mt-20">--}}
                {{--<div class="panel-header clearfix">--}}
                    {{--<span class="f-l">lib中的第三方插件</span>--}}
                    {{--<span class="f-r">非必选插件，请有选择性的使用，用不上的可自行删除，减少框架体积</span>--}}
                {{--</div>--}}
                {{--<div class="panel-body">--}}
                    {{--<table class="table table-border table-bordered table-bg">--}}
                        {{--<thead>--}}
                        {{--<tr>--}}
                            {{--<th width="30%">名称</th>--}}
                            {{--<th width="20%">版本号</th>--}}
                            {{--<th>描述</th>--}}
                        {{--</tr>--}}
                        {{--</thead>--}}
                        {{--<tbody>--}}
                        {{--<tr>--}}
                            {{--<td>jQuery.js</td>--}}
                            {{--<td>1.9.1</td>--}}
                            {{--<td>jQuery库，可自行下载新版本，替换现有版本。</td>--}}
                        {{--</tr>--}}
                        {{--<tr>--}}
                            {{--<td>Hui-iconfont</td>--}}
                            {{--<td>1.0.8</td>--}}
                            {{--<td>阿里图标字体库（H-ui定制）</td>--}}
                        {{--</tr>--}}
                        {{--<tr>--}}
                            {{--<td>jquery.SuperSlide</td>--}}
                            {{--<td>2.1.1</td>--}}
                            {{--<td>幻灯片组件</td>--}}
                        {{--</tr>--}}
                        {{--<tr>--}}
                            {{--<td>Validform</td>--}}
                            {{--<td>5.3.2</td>--}}
                            {{--<td>表单验证插件</td>--}}
                        {{--</tr>--}}
                        {{--<tr>--}}
                            {{--<td>jquery.validation</td>--}}
                            {{--<td>1.14.0</td>--}}
                            {{--<td>表单验证插件</td>--}}
                        {{--</tr>--}}
                        {{--<tr>--}}
                            {{--<td>My97DatePicker</td>--}}
                            {{--<td>4.8</td>--}}
                            {{--<td>日期插件</td>--}}
                        {{--</tr>--}}
                        {{--<tr>--}}
                            {{--<td>datatables</td>--}}
                            {{--<td>1.10.0</td>--}}
                            {{--<td>表格插件</td>--}}
                        {{--</tr>--}}
                        {{--<tr>--}}
                            {{--<td>nprogress</td>--}}
                            {{--<td>0.2.0</td>--}}
                            {{--<td>进度条插件</td>--}}
                        {{--</tr>--}}
                        {{--<tr>--}}
                            {{--<td>layer</td>--}}
                            {{--<td>2.4</td>--}}
                            {{--<td>layer弹出层插件</td>--}}
                        {{--</tr>--}}
                        {{--<tr>--}}
                            {{--<td>laypage</td>--}}
                            {{--<td>1.2</td>--}}
                            {{--<td>laypage 翻页插件</td>--}}
                        {{--</tr>--}}
                        {{--<tr>--}}
                            {{--<td>html5shiv.js</td>--}}
                            {{--<td><3.7.0/td>--}}
                            {{--<td>html5插件，让低版本IE支持html5元素</td>--}}
                        {{--</tr>--}}
                        {{--<tr>--}}
                            {{--<td>DD_belatedPNG_0.0.8a-min.js</td>--}}
                            {{--<td>0.0.8a</td>--}}
                            {{--<td>解决IE6png透明</td>--}}
                        {{--</tr>--}}
                        {{--<tr>--}}
                            {{--<td>swfobject.js</td>--}}
                            {{--<td>2.2</td>--}}
                            {{--<td>Flash插件</td>--}}
                        {{--</tr>--}}
                        {{--<tr>--}}
                            {{--<td>waterfall.min</td>--}}
                            {{--<td>0.1.6</td>--}}
                            {{--<td>瀑布流插件</td>--}}
                        {{--</tr>--}}
                        {{--</tbody>--}}
                    {{--</table>--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}

@endsection



@section('script')

@endsection