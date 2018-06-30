@extends('layouts.adminchild')
@section('title','修改密码')
@section('content')
    <article class="page-container">
        <form action="{{route('memberAdd')}}" method="post" class="form form-horizontal" id="form-member-add" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="id" value="{{!empty($user->id) ? $user->id:''}}">

            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>新密码：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="password" class="input-text" autocomplete="off" value="" placeholder="请输入新密码" id="password" name="password">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>确认密码：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="password2" class="input-text" autocomplete="off" value="" placeholder="请输入确认密码" id="password2" name="password2">
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
            $("#form-member-add").validate({
                rules:{
                    password:{
                        required:true,
                        minlength:6,
                        maxlength:16,
                    },
                    password2:{
                        required:true,
                        minlength:6,
                        maxlength:16,
                        equalTo: "#password"
                    }
                },
                onkeyup:false,
                focusCleanup:true,
                success:"valid",
                submitHandler:function(form){
                    $(form).ajaxSubmit({
                        type: 'post',
                        url: "{{route('changePassword')}}" ,
                        success: function(data){
                            if (data.code == 200) {
                                layer.msg(data.msg,{icon:1,time:1000});
                                setTimeout(function () {
                                    var index = parent.layer.getFrameIndex(window.name);
                                    // parent.$('.btn-refresh').click();
                                    // parent.window.location.reload();
                                    parent.layer.close(index);
                                },1000);
                            } else {
                                layer.msg(data.msg,{icon:2,time:1500})
                            }
                        },

                    });
                }
            });



        });

    </script>

@endsection

