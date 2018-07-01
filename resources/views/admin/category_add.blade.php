@extends('layouts.adminchild')
@section('title','添加产品分类')
@section('content')
    <div class="page-container">
        <form action="{{route('categoryAdd')}}" method="post" class="form form-horizontal" id="form-category-add">
            @csrf
            <input type="hidden" name="id" value="{{!empty($category->id) ? $category->id:(!empty($_GET['id']) ? $_GET['id'] : '')}}">
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-2">
                    <span class="c-red">*</span>
                    上级分类：</label>
                <div class="formControls col-xs-6 col-sm-6">
						<span class="select-box">
						<select class="select" id="sel_Sub" name="parent_id">
							<option value="0">顶级分类</option>
                            @if(!empty($category))
                                @foreach($category as $k => $v)
                                    @if(!empty($data) && ($v['id'] == $data['parent_id']))
                                        <option value="{{$v['id']}}" selected="selected">{{$v['name']}}</option>
                                    @else
                                        <option value="{{$v['id']}}">{{$v['name']}}</option>
                                    @endif
                                    @if(isset($v['list']) && !empty($v['list']))
                                        @foreach($v['list'] as $k1 => $v1)
                                            @if(!empty($data) && ($v1['id'] == $data['parent_id']))
                                                <option value="{{$v1['id']}}" selected="selected">{{$v1['name']}}</option>
                                            @else
                                                @if(!empty($data))
                                                    <option value="{{$v1['id']}}" disabled>&nbsp;&nbsp;├ {{$v1['name']}}</option>
                                                @else
                                                    <option value="{{$v1['id']}}">&nbsp;&nbsp;├ {{$v1['name']}}</option>
                                                @endif
                                            @endif
                                        @endforeach
                                    @endif
                                @endforeach
                            @endif
						</select>
						</span>
                </div>
                <div class="col-3">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-2">
                    <span class="c-red">*</span>
                    分类名称：</label>
                <div class="formControls col-xs-6 col-sm-6">
                    <input type="text" class="input-text" value="{{!empty($data) ? $data['name'] : ''}}" placeholder="请输入分类名称" id="name" name="name">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-2">
                    <span class="c-red">*</span>
                    排序：</label>
                <div class="formControls col-xs-6 col-sm-6">
                    <input type="text" class="input-text" value="{{!empty($data) ? $data['sort'] : '50'}}" placeholder="请输入排序" id="sort" name="sort" onkeyup="(this.v=function(){this.value=this.value.replace(/[^0-9-]+/,'');}).call(this)" onblur="this.v();">
                </div>
            </div>
            @if(!empty($data))
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-2">
                    状态：</label>
                <div class="formControls col-xs-6 col-sm-6">
						<span class="select-box">
                            <select class="select" name="status" >
                                <option value="1" {{($data['status'] == 1) ? 'selected="selected"' : ''}}>启用</option>
                                <option value="0" {{($data['status'] == 0) ? 'selected="selected"' : ''}}>停用</option>
                            </select>
                        </span>
                </div>
            </div>
            @endif
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-2">备注：</label>
                <div class="formControls col-xs-6 col-sm-6">
                    <textarea name="desc" cols="" rows="" class="textarea"  placeholder="说点什么...最少输入10个字符" onKeyUp="Huitextarealength(this,100)" style="margin-top: 25px;">{{!empty($data) ? $data['desc'] : ''}}</textarea>
                    <p class="textarea-numberbar"><em class="textarea-length">{{!empty($data) ? strlen($data['desc']) : ''}}</em>/100</p>
                </div>
            </div>
            <div class="row cl">
                <div class="col-9 col-offset-2">
                    <input class="btn btn-primary radius" type="submit" onclick="return checkAuth1()" value="&nbsp;&nbsp;{{!empty($data) ? '修改' : '提交'}}&nbsp;&nbsp;">
                    @if(!empty($data))
                    <a href="javascript:;" class="btn btn-danger radius " style="margin-left: 20px;" onclick="del('{{$data['id']}}')">&nbsp;&nbsp;删除&nbsp;&nbsp;</a>
                    @endif
                </div>
            </div>
        </form>
    </div>
@endsection

@section('script')
    <script type="text/javascript" src="{{ asset('lib/My97DatePicker/4.8/WdatePicker.js') }}"></script>
    <script type="text/javascript" src="{{ asset('lib/jquery.validation/1.14.0/jquery.validate.js') }}"></script>
    <script type="text/javascript" src="{{ asset('lib/jquery.validation/1.14.0/validate-methods.js') }}"></script>
    <script type="text/javascript" src="{{ asset('lib/jquery.validation/1.14.0/messages_zh.js') }}"></script>
    <script type="text/javascript">
        $(function(){
            $("#form-category-add").validate({
                rules:{
                    name:{
                        required:true,
                        minlength:2,
                        maxlength:16
                    },
                    desc:{
                        maxlength:100,
                    },
                    sort:{
                        required:true
                    }
                },
                onkeyup:false,
                focusCleanup:true,
                success:"valid",
                submitHandler:function(form){
                    $(form).ajaxSubmit({
                        type: 'post',
                        url: "{{route('categoryAdd')}}" ,
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
        function del(id) {
            if (checkAuth('categoryDel') == 0) {
                return false;
            };
            $.ajax({
                type: 'post',
                url: '{{route('categoryDel')}}',
                data: {_token: _token, id: id},
                dataType: 'json',
                success: function (data) {
                    if (data.code == 200) {
                        layer.msg(data.msg, {icon: 1, time: 1000});
                        setTimeout(function () {
                            var index = parent.layer.getFrameIndex(window.name);
                            // parent.$('.btn-refresh').click();
                            parent.window.location.reload();
                            parent.layer.close(index);
                        }, 1000);
                    } else {
                        layer.msg(data.msg, {icon: 2, time: 1500})
                    }
                }
            });
        }
        function checkAuth1() {
            if (checkAuth('categoryAdd') == 0) {
                return false;
            } else {
                return true;
            }
        }
    </script>

@endsection

