@extends('layouts.adminchild')
@section('title','添加用户')
@section('content')
    <article class="page-container">
        <form action="{{route('memberAdd')}}" method="post" class="form form-horizontal" id="form-member-add">
            @csrf
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>用户名：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" class="input-text" value="" placeholder="请输入用户名" id="name" name="name">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>性别：</label>
                <div class="formControls col-xs-8 col-sm-9 skin-minimal">
                    <div class="radio-box">
                        <input name="sex" type="radio" id="sex-1" value="1" checked>
                        <label for="sex-1">男</label>
                    </div>
                    <div class="radio-box">
                        <input type="radio" id="sex-2" name="sex" value="2">
                        <label for="sex-2">女</label>
                    </div>
                    <div class="radio-box">
                        <input type="radio" id="sex-3" name="sex" value="3">
                        <label for="sex-3">保密</label>
                    </div>
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>手机：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" class="input-text" value="" placeholder="" id="mobile" name="mobile">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>邮箱：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" class="input-text" placeholder="@" name="email" id="email">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3">头像：</label>
                <div class="formControls col-xs-8 col-sm-9"> <span class="btn-upload form-group">
				<input class="input-text upload-url" type="text" name="avatar" id="uploadfile" readonly nullmsg="请添加头像！" style="width:200px">
				<a href="javascript:;" class="btn btn-primary radius upload-btn"><i class="Hui-iconfont">&#xe642;</i> 浏览文件</a>
				<input type="file" multiple name="file-2" class="input-file">
				</span> </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3">所在城市：</label>
                <div class="col-xs-8 col-sm-9">
                    <div class="formControls col-xs-4 col-sm-4" style="padding: 0px 5px 0px 0px;"id="area">
                        <span class="select-box">
                            <select class="select" size="1" name="area">
                                <option value="0" name="code">--请选择--</option>
                            </select>
                        </span>
                    </div>
                    <div class="formControls col-xs-4 col-sm-4" style="padding: 0px 0px 0px 5px;" id="city">
                        <span class="select-box">
                            <select class="select" size="1" name="city">
                                <option value="0" name="code">--请选择--</option>
                            </select>
                        </span>
                    </div>
                    <div class="formControls col-xs-4 col-sm-4" style="padding: 0px 0px 0px 5px;" id="county">
                        <span class="select-box">
                            <select class="select" size="1" name="county">
                                <option value="0" name="code">--请选择--</option>
                            </select>
                        </span>
                    </div>
                </div>

            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3">个人描述：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <textarea name="desc" cols="" rows="" class="textarea"  placeholder="说点什么...最少输入10个字符" dragonfly="true" onKeyUp="Huitextarealength(this,100)" style="margin-top: 25px;"></textarea>
                    <p class="textarea-numberbar"><em class="textarea-length">0</em>/100</p>
                </div>
            </div>
            <div class="row cl">
                <div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-3">
                    <input class="btn btn-primary radius" type="submit" value="&nbsp;&nbsp;提交&nbsp;&nbsp;">
                </div>
            </div>
        </form>
    </article>
@endsection

@section('script')
    <script type="text/javascript" src="{{ asset('lib/My97DatePicker/4.8/WdatePicker.js') }}"></script>
    <script type="text/javascript" src="{{ asset('lib/jquery.validation/1.14.0/jquery.validate.js') }}"></script>
    <script type="text/javascript" src="{{ asset('lib/jquery.validation/1.14.0/validate-methods.js') }}"></script>
    <script type="text/javascript" src="{{ asset('lib/jquery.validation/1.14.0/messages_zh.js') }}"></script>
    <script type="text/javascript">
        $(function(){
            $('.skin-minimal input').iCheck({
                checkboxClass: 'icheckbox-blue',
                radioClass: 'iradio-blue',
                increaseArea: '20%'
            });

            $("#form-member-add").validate({
                rules:{
                    name:{
                        required:true,
                        minlength:2,
                        maxlength:16
                    },
                    sex:{
                        required:true,
                    },
                    mobile:{
                        required:true,
                        isMobile:true,
                    },
                    email:{
                        required:true,
                        email:true,
                    },
                    desc:{
                        maxlength:100,
                    }
                    // uploadfile:{
                    //     required:true,
                    // },

                },
                onkeyup:false,
                focusCleanup:true,
                success:"valid",
                submitHandler:function(form){
                    return true;
                    //$(form).ajaxSubmit();
                    // var index = parent.layer.getFrameIndex(window.name);
                    //parent.$('.btn-refresh').click();
                    // parent.layer.close(index);
                }
            });

            $.ajax({
                type:"post",
                url: "{{route('citySelect')}}",
                data:{_token:_token,parent_id:0},
                dataType:"json",//指定返回的格式
                success:function(data){
                    for(var i=0;i<data.data.length;i++){
                        var code=data.data[i].code//返回对象的一个属性
                        var name=data.data[i].name;
                        $("<option value='"+code+"'>"+name+"</option>").appendTo($("#area select"));//添加下拉列表
                    }
                }
            });

            $("#area").change(function() {
                //清空下面两个子下拉列表(option中value值大于0的删除)
                $("#city option:gt(0)").remove();
                $("#county option:gt(0)").remove();
                if ($("#area select").val() == 0) {
                    return;//没有选择的就不去调用
                }
                $.ajax({
                    type:"post",
                    url: "{{route('citySelect')}}",
                    data:{_token:_token,parent_id:$("#area select").val()},
                    dataType:"json",//指定返回的格式
                    success:function(data){
                        for(var i=0;i<data.data.length;i++){
                            var code=data.data[i].code//返回对象的一个属性
                            var name=data.data[i].name;
                            $("<option value='"+code+"'>"+name+"</option>").appendTo($("#city select"));//添加下拉列表
                        }
                    }
                });
            });

            $("#city").change(function() {
                //清空下面两个子下拉列表(option中value值大于0的删除)
                $("#county option:gt(0)").remove();
                if ($("#city select").val() == 0) {
                    return;//没有选择的就不去调用
                }
                $.ajax({
                    type:"post",
                    url: "{{route('citySelect')}}",
                    data:{_token:_token,parent_id:$("#city select").val()},
                    dataType:"json",//指定返回的格式
                    success:function(data){
                        for(var i=0;i<data.data.length;i++){
                            var code=data.data[i].code//返回对象的一个属性
                            var name=data.data[i].name;
                            $("<option value='"+code+"'>"+name+"</option>").appendTo($("#county select"));//添加下拉列表
                        }
                    }
                });

            });
        });
        function Huitextarealength(obj,max) {
            var defaults = {
                minlength:0,
                maxlength:max,
                errorClass:"error",
                exceed:true,
            }
            var options = $.extend(defaults, options);
            var that = $(obj);
            var v = that.val();
            var l = v.length;
            if (l > options.maxlength) {
                if(options.exceed){
                    that.addClass(options.errorClass);
                }else{
                    v = v.substring(0, options.maxlength);
                    that.val(v);
                    that.removeClass(options.errorClass);
                }
            } else if(l<options.minlength){
                that.addClass(options.errorClass);
            }else{
                that.removeClass(options.errorClass);
            }
            that.parent().find(".textarea-length").text(v.length);
        }
    </script>
    {{--<script type="text/javascript">--}}
        {{--$(function(){--}}
            {{--$('.skin-minimal input').iCheck({--}}
                {{--checkboxClass: 'icheckbox-blue',--}}
                {{--radioClass: 'iradio-blue',--}}
                {{--increaseArea: '20%'--}}
            {{--});--}}

            {{--$("#form-admin-add").validate({--}}
                {{--rules:{--}}
                    {{--name:{--}}
                        {{--required:true,--}}
                        {{--minlength:2,--}}
                        {{--maxlength:10--}}
                    {{--},--}}
                    {{--password:{--}}
                        {{--required:'{{!empty($adminUser->id) ? false : true}}',--}}
                        {{--minlength:4,--}}
                        {{--maxlength:30--}}
                    {{--},--}}
                    {{--password2:{--}}
                        {{--required:'{{!empty($adminUser->id) ? false : true}}',--}}
                        {{--minlength:4,--}}
                        {{--maxlength:30,--}}
                        {{--equalTo: "#password"--}}
                    {{--},--}}
                    {{--sex:{--}}
                        {{--required:true,--}}
                    {{--},--}}
                    {{--mobile:{--}}
                        {{--required:true,--}}
                        {{--isPhone:true,--}}
                    {{--},--}}
                    {{--email:{--}}
                        {{--required:true,--}}
                        {{--email:true,--}}
                    {{--},--}}
                    {{--role_id:{--}}
                        {{--required:true,--}}
                    {{--},--}}
                    {{--desc:{--}}
                        {{--maxlength:100,--}}
                    {{--}--}}
                {{--},--}}
                {{--onkeyup:false,--}}
                {{--focusCleanup:true,--}}
                {{--success:"valid",--}}
                {{--submitHandler:function(form){--}}
                    {{--$(form).ajaxSubmit({--}}
                        {{--type: 'post',--}}
                        {{--url: "{{route('managerAdd')}}" ,--}}
                        {{--success: function(data){--}}
                            {{--if (data.code == 200) {--}}
                                {{--layer.msg(data.msg,{icon:1,time:1000});--}}
                                {{--setTimeout(function () {--}}
                                    {{--var index = parent.layer.getFrameIndex(window.name);--}}
                                    {{--// parent.$('.btn-refresh').click();--}}
                                    {{--parent.window.location.reload();--}}
                                    {{--parent.layer.close(index);--}}
                                {{--},1000);--}}
                            {{--} else {--}}
                                {{--layer.msg(data.msg,{icon:2,time:1500})--}}
                            {{--}--}}
                        {{--},--}}
                        {{--// error: function(XmlHttpRequest, textStatus, errorThrown){--}}
                        {{--//     layer.msg('error!',{icon:1,time:1000});--}}
                        {{--// }--}}
                    {{--});--}}
                    {{--// var index = parent.layer.getFrameIndex(window.name);--}}
                    {{--// parent.$('.btn-refresh').click();--}}
                    {{--// parent.layer.close(index);--}}
                {{--}--}}
            {{--});--}}

        {{--});--}}

        {{--function Huitextarealength(obj,max) {--}}
            {{--var defaults = {--}}
                {{--minlength:0,--}}
                {{--maxlength:max,--}}
                {{--errorClass:"error",--}}
                {{--exceed:true,--}}
            {{--}--}}
            {{--var options = $.extend(defaults, options);--}}
            {{--var that = $(obj);--}}
            {{--var v = that.val();--}}
            {{--var l = v.length;--}}
            {{--if (l > options.maxlength) {--}}
                {{--if(options.exceed){--}}
                    {{--that.addClass(options.errorClass);--}}
                {{--}else{--}}
                    {{--v = v.substring(0, options.maxlength);--}}
                    {{--that.val(v);--}}
                    {{--that.removeClass(options.errorClass);--}}
                {{--}--}}
            {{--} else if(l<options.minlength){--}}
                {{--that.addClass(options.errorClass);--}}
            {{--}else{--}}
                {{--that.removeClass(options.errorClass);--}}
            {{--}--}}
            {{--that.parent().find(".textarea-length").text(v.length);--}}
        {{--}--}}

    {{--</script>--}}
@endsection

