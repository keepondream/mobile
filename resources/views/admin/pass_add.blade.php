@extends('layouts.adminchild')
@section('title','添加用户')
@section('content')
    <article class="page-container">
        <form action="{{route('memberAdd')}}" method="post" class="form form-horizontal" id="form-member-add" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="id" value="{{!empty($brand->id) ? $brand->id:''}}">
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>平台名称：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" class="input-text" value="{{!empty($brand->name) ? $brand->name : ''}}" placeholder="请输入平台名称" id="name" name="name">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3">
                    <span class="c-red">*</span>
                    排序：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" class="input-text" value="{{!empty($brand->sort) ? $brand->sort : '50'}}" placeholder="请输入排序" id="sort" name="sort" onkeyup="(this.v=function(){this.value=this.value.replace(/[^0-9-]+/,'');}).call(this)" onblur="this.v();">
                </div>
            </div>
            @if(!empty($brand->id))
                <div class="row cl">
                    <label class="form-label col-xs-4 col-sm-3">
                        状态：</label>
                    <div class="formControls col-xs-8 col-sm-9">
						<span class="select-box">
                            <select class="select" name="status" >
                                <option value="1" {{($brand->status == 1) ? 'selected="selected"' : ''}}>启用</option>
                                <option value="0" {{($brand->status == 0) ? 'selected="selected"' : ''}}>停用</option>
                            </select>
                        </span>
                    </div>
                </div>
            @endif
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3">备注：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <textarea id="desc" name="desc" cols="5" rows="5" class="textarea"  placeholder="说点什么...100个字符以内" dragonfly="true" onKeyUp="Huitextarealength(this,100)" style="margin-top: 25px;">{{!empty($brand->desc) ? $brand->desc : ''}}</textarea>
                    <p class="textarea-numberbar"><em class="textarea-length">{{!empty($brand->desc) ? strlen($brand->desc) : '0'}}</em>/100</p>
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
                    },
                    desc:{
                        maxlength:100,
                    },
                },
                onkeyup:false,
                focusCleanup:true,
                success:"valid",
                submitHandler:function(form){
                    $(form).ajaxSubmit({
                        type: 'post',
                        url: "{{route('paasAdd')}}" ,
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

                    });
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

本周工作:
1.增加狗太公众号活动图片上传更改功能
2.修复SaaS微房产H5活动新增和编辑功能,并增加活动图片更换功能
3.修改公众号关键词回复新房和小区单独发送和显示的价格字段调整
4.查看公众号活动抽奖功能不能发送原因
5.增加消息推送退款,退订,退房和对应审核的消息入口和推送功能
6.修改后台经纪人赠送积分功能限制
7.修改后台h5活动动态添加
8.配合移动端修改消息推送并测试

