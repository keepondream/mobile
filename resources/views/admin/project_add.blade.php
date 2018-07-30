@extends('layouts.adminchild')
@section('title','添加项目')
@section('content')
    <article class="page-container">
        <form action="{{route('memberAdd')}}" method="post" class="form form-horizontal" id="form-member-add" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="id" value="{{!empty($project->id) ? $project->id:''}}">
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>项目名称：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" class="input-text" value="{{!empty($project->name) ? $project->name : ''}}" placeholder="请输入项目名称" id="name" name="name">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>项目编号：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" class="input-text" value="{{!empty($project->sign) ? $project->sign : ''}}" placeholder="请输入项目编号" id="sign" name="sign">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3">
                    <span class="c-red">*</span>
                    所属平台：</label>
                <div class="formControls col-xs-8 col-sm-9">
						<span class="select-box">
						<select class="select" id="sel_Sub" name="brand_id">
                            @if(!empty($brands) && (count($brands) > 0))
                                @foreach($brands as $k => $v)
                                    @if(!empty($project) &&($project->brand_id == $v['id']))
                                        <option value="{{$v['id']}}" selected="selected">{{$v['name']}}</option>
                                    @else
                                        <option value="{{$v['id']}}">{{$v['name']}}</option>
                                    @endif
                                @endforeach
                            @else
                                <option value="">--暂无平台--</option>
                            @endif
						</select>
						</span>
                </div>
                <div class="col-3">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3">
                    <span class="c-red">*</span>
                    排序：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" class="input-text" value="{{!empty($project->sort) ? $project->sort : '50'}}" placeholder="请输入排序" id="sort" name="sort" onkeyup="(this.v=function(){this.value=this.value.replace(/[^0-9-]+/,'');}).call(this)" onblur="this.v();">
                </div>
            </div>
            @if(!empty($project->id))
                <div class="row cl">
                    <label class="form-label col-xs-4 col-sm-3">
                        状态：</label>
                    <div class="formControls col-xs-8 col-sm-9">
						<span class="select-box">
                            <select class="select" name="status" >
                                <option value="1" {{($project->status == 1) ? 'selected="selected"' : ''}}>启用</option>
                                <option value="0" {{($project->status == 0) ? 'selected="selected"' : ''}}>停用</option>
                            </select>
                        </span>
                    </div>
                </div>
            @endif
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3">项目描述：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <textarea id="desc" name="desc" cols="5" rows="5" class="textarea"  placeholder="说点什么...100个字符以内" dragonfly="true" onKeyUp="Huitextarealength(this,100)" style="margin-top: 25px;">{{!empty($project->desc) ? $project->desc : ''}}</textarea>
                    <p class="textarea-numberbar"><em class="textarea-length">{{!empty($project->desc) ? strlen($project->desc) : '0'}}</em>/100</p>
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
                    sign:{
                        required:true,
                    },
                    brand_id:{
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
                        url: "{{route('projectAdd')}}" ,
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


