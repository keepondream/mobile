@extends('layouts.adminchild')
@section('title','添加权限')
@section('content')
    <article class="page-container">
        <form class="form form-horizontal" id="form-admin-add">
            @csrf
            <input type="hidden" name="id" value="{{!empty($adminUser->id) ? $adminUser->id:''}}">
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>管理员账号：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" class="input-text" value="{{!empty($adminUser->name) ? $adminUser->name : ''}}" placeholder="请输入管理员名称" id="name" name="name">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><?php echo !empty($adminUser->id) ? '' : '<span class="c-red">*</span>'?>{{!empty($adminUser->id) ? '修改' : ''}}初始密码：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="password" class="input-text" autocomplete="off" value="" placeholder="{{!empty($adminUser->id) ? '请输入新密码,如不修改密码可为空' : '请输入新密码'}}" id="password" name="password">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><?php echo !empty($adminUser->id) ? '' : '<span class="c-red">*</span>'?>确认{{!empty($adminUser->id) ? '修改' : ''}}密码：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="password" class="input-text" autocomplete="off"  placeholder="{{!empty($adminUser->id) ? '确认新密码,如不修改密码可为空' : '确认新密码'}}" id="password2" name="password2">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>性别：</label>
                <div class="formControls col-xs-8 col-sm-9 skin-minimal">
                    <div class="radio-box">
                        <input name="sex" type="radio" id="sex-1" value="1" {{(!empty($adminUser->status)) ? ($adminUser->status == 1 ? 'checked' : '') : 'checked'}}>
                        <label for="sex-1">男</label>
                    </div>
                    <div class="radio-box">
                        <input type="radio" id="sex-2" name="sex" value="2" {{(!empty($adminUser->status)) ? ($adminUser->status == 2 ? 'checked' : '') : ''}}>
                        <label for="sex-2">女</label>
                    </div>
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>手机：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" class="input-text" value="{{!empty($adminUser->mobile) ? $adminUser->mobile : ''}}" placeholder="" id="mobile" name="mobile" maxlength="11">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>邮箱：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" class="input-text" placeholder="请输入邮箱 如:xxx@xxx.xxx" name="email" id="email" value="{{!empty($adminUser->email) ? $adminUser->email : ''}}">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3">角色：</label>
                <div class="formControls col-xs-8 col-sm-9"> <span class="select-box" style="width:150px;">
			<select class="select" name="role_id" size="1">
                @foreach($roles as $role)
                        <option value="{{$role['id']}}" {{(!empty($adminUser->role_id) && ($adminUser->role_id == $role['id'])) ? 'selected' : ''}}>{{$role['name']}}</option>
                @endforeach
			</select>
			</span> </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3">备注：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <textarea id="desc" name="desc" cols="5" rows="5" class="textarea"  placeholder="说点什么...100个字符以内" dragonfly="true" onKeyUp="Huitextarealength(this,100)" style="margin-top: 25px;">{{!empty($adminUser->desc) ? $adminUser->desc : ''}}</textarea>
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

            $("#form-admin-add").validate({
                rules:{
                    name:{
                        required:true,
                        minlength:2,
                        maxlength:10
                    },
                    password:{
                        required:'{{!empty($adminUser->id) ? false : true}}',
                        minlength:4,
                        maxlength:30
                    },
                    password2:{
                        required:'{{!empty($adminUser->id) ? false : true}}',
                        minlength:4,
                        maxlength:30,
                        equalTo: "#password"
                    },
                    sex:{
                        required:true,
                    },
                    mobile:{
                        required:true,
                        isPhone:true,
                    },
                    email:{
                        required:true,
                        email:true,
                    },
                    role_id:{
                        required:true,
                    },
                    desc:{
                        maxlength:100,
                    }
                },
                onkeyup:false,
                focusCleanup:true,
                success:"valid",
                submitHandler:function(form){
                    $(form).ajaxSubmit({
                        type: 'post',
                        url: "{{route('managerAdd')}}" ,
                        success: function(data){
                            if (data.code == 200) {
                                layer.msg(data.msg,{icon:1,time:1000});
                                setTimeout(function () {
                                    var index = parent.layer.getFrameIndex(window.name);
                                    // parent.$('.btn-refresh').click();
                                    parent.window.location.reload();
                                    parent.layer.close(index);
                                },1000);
                            } else {
                                layer.msg(data.msg,{icon:2,time:1500})
                            }
                        },
                        // error: function(XmlHttpRequest, textStatus, errorThrown){
                        //     layer.msg('error!',{icon:1,time:1000});
                        // }
                    });
                    // var index = parent.layer.getFrameIndex(window.name);
                    // parent.$('.btn-refresh').click();
                    // parent.layer.close(index);
                }
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
@endsection

