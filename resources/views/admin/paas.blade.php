@extends('layouts.adminchild')
@section('title','平台管理')
@section('content')
    <nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 产品管理 <span
                class="c-gray en">&gt;</span> 平台管理 <a class="btn btn-success radius r"
                                                      style="line-height:1.6em;margin-top:3px"
                                                      href="javascript:location.replace(location.href);" title="刷新"><i
                    class="Hui-iconfont">&#xe68f;</i></a></nav>
    <div class="page-container">
        <div class="text-c">
            <form class="Huiform" method="post" action="{{route('paasAdd')}}" id="form-category-add">
                @csrf
                <input type="text" placeholder="请输入平台名称" value="" name="name" class="input-text" style="width:120px">
                {{--<span class="btn-upload form-group">--}}
                {{--<input class="input-text upload-url" type="text" name="uploadfile-2" id="uploadfile-2" readonly style="width:200px">--}}
                {{--<a href="javascript:void(0);" class="btn btn-primary upload-btn"><i class="Hui-iconfont">&#xe642;</i> 上传logo</a>--}}
                {{--<input type="file" multiple name="file-2" class="input-file">--}}
                {{--</span> --}}
                <span class="select-box" style="width:150px">
                    <select class="select" name="category_id" size="1">
                        @if(!empty($category) && count($category) > 0)
                            @foreach($category as $value)
                                <option value="{{$value->id}}">{{$value->name}}</option>
                            @endforeach
                        @else
                            <option value="">--暂无分类--</option>
                        @endif
                    </select>
			    </span>
                <button type="submit" class="btn btn-success" onclick="return checkAuth1()"><i class="Hui-iconfont">&#xe600;</i> 添加</button>
            </form>
        </div>
        <div class="cl pd-5 bg-1 bk-gray mt-20"><span class="l">
                <a href="javascript:;" onclick="datadel()" class="btn btn-danger radius"><i class="Hui-iconfont">&#xe6e2;</i> 批量删除</a></span> <span class="r">共有数据：<strong>{{count($brands)}}</strong> 条</span>
        </div>
        <div class="mt-20">
            <table class="table table-border table-bordered table-bg table-sort">
                <thead>
                <tr class="text-c">
                    <th width="25"><input type="checkbox" name="" value=""></th>
                    <th width="70">ID</th>
                    <th width="150">平台名称</th>
                    <th>具体描述</th>
                    <th width="80">排序</th>
                    <th width="70">状态</th>
                    <th width="100">操作</th>
                </tr>
                </thead>
                <tbody>
                @if(count($brands) > 0)
                    @foreach($brands as $brand)
                        <tr class="text-c">
                            <td><input name="ids" type="checkbox" value="{{$brand->id}}"></td>
                            <td>{{$brand->id}}</td>
                            {{--<td><input type="text" class="input-text text-c" value="{{$brand->sort}}" onkeyup="(this.v=function(){this.value=this.value.replace(/[^0-9-]+/,''); }).call(this)" onblur="this.v();changeSort(this,{{$brand->id}})"></td>--}}
                            {{--<td style="display: none;">{{$brand->sort}}</td>--}}
                            {{--<td><img src="temp/brand/dongpeng.jpeg"></td>--}}
                            {{--<td class="text-l"><img title="国内品牌" src="static/h-ui.admin/images/cn.gif"> 东鹏</td>--}}
                            <td class="text-l">{{$brand->name}}</td>
                            <td class="text-l">{{$brand->desc}}</td>
                            <td>{{$brand->sort}}</td>
                        @if($brand->status == 1)
                                <td class="td-status"><span class="label label-success radius">已启用</span></td>
                                <td class="f-14 product-brand-manage">
                                    <a style="text-decoration:none" onClick="member_stop(this,'{{$brand->id}}')" href="javascript:;" title="停用"><i class="Hui-iconfont">&#xe631;</i></a>
                                    <a style="text-decoration:none" onClick="product_brand_edit('平台编辑','{{route('paasAdd')}}','1')" href="javascript:;" title="编辑"><i class="Hui-iconfont">&#xe6df;</i></a>
                                    <a style="text-decoration:none" class="ml-5" onClick="system_category_del(this,'{{$brand->id}}')" href="javascript:;" title="删除"><i class="Hui-iconfont">&#xe6e2;</i></a>
                                </td>
                            @else
                                <td class="td-status"><span class="label radius">已停用</span></td>
                                <td class="f-14 product-brand-manage">
                                    <a style="text-decoration:none" onClick="member_start(this,'{{$brand->id}}')" href="javascript:;" title="启用"><i class="Hui-iconfont">&#xe6e1;</i></a>
                                    <a style="text-decoration:none" onClick="product_brand_edit('平台编辑','{{route('paasAdd')}}','1')" href="javascript:;" title="编辑"><i class="Hui-iconfont">&#xe6df;</i></a>
                                    <a style="text-decoration:none" class="ml-5" onClick="system_category_del(this,'{{$brand->id}}')" href="javascript:;" title="删除"><i class="Hui-iconfont">&#xe6e2;</i></a>
                                </td>
                            @endif
                        </tr>
                    @endforeach
                @endif

                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('script')
    <script type="text/javascript" src="{{ asset('lib/My97DatePicker/4.8/WdatePicker.js') }}"></script>
    <script type="text/javascript" src="{{ asset('lib/datatables/1.10.0/jquery.dataTables.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('lib/laypage/1.2/laypage.js') }}"></script>
    <script type="text/javascript" src="{{ asset('lib/jquery.validation/1.14.0/jquery.validate.js') }}"></script>
    <script type="text/javascript" src="{{ asset('lib/jquery.validation/1.14.0/validate-methods.js') }}"></script>
    <script type="text/javascript" src="{{ asset('lib/jquery.validation/1.14.0/messages_zh.js') }}"></script>
    <script type="text/javascript">
        $('.table-sort').dataTable({
            "aaSorting": [[1, "asc"]],//默认第几个排序
            "bStateSave": true,//状态保存
            "aoColumnDefs": [
                // {"bVisible": false, "aTargets": [ 3 ]}, //控制列的隐藏显示
                {"orderable": false, "aTargets": [0,2,3,5,6]}// 制定列不参与排序
            ]
        });
        //审核添加权限
        function checkAuth1() {
            if (checkAuth('paasAdd') == 0) {
                return false;
            } else {
                return true;
            }
        }
        //添加
        $("#form-category-add").validate({
            rules:{
                category_id:"required",
                name:"required",
            },
            onkeyup:false,
            focusCleanup:true,
            success:"valid",
            submitHandler:function(form){
                $(form).ajaxSubmit(function (data) {
                    if (data.code != 200) {
                        layer.msg(data.msg,{icon:2,time:1500})
                    } else {
                        layer.msg(data.msg,{icon:1,time:1000})
                        setTimeout(function () {
                            // var index = parent.layer.getFrameIndex(window.name);
                            // parent.$('.btn-refresh').click();
                            window.location.reload();
                            // parent.layer.close(index);
                        },1000);
                    }
                });
            }
        });
        //排序
        function changeSort(obj,id) {
            if ($(obj).val() == '') {
                layer.msg('排序不能为空!~',{icon:2,time:1000})
            } else {
                console.log($(obj).val());
                console.log(id);
            }

        }
        /*编辑*/
        function product_brand_edit(title,url,id,w,h){
            if (checkAuth('paasAdd') == 0) {
                return false;
            };
            layer_show(title,url,w,h);
        }
        /*停用*/
        function member_stop(obj,id){
            if (checkAuth('paasAudit') == 0) {
                return false;
            };
            layer.confirm('确认要停用吗？',function(index){
                $.ajax({
                    type: 'POST',
                    url: '{{route('passStatus')}}',
                    data:{_token:_token,id:id,status:'0'},
                    dataType: 'json',
                    success: function(data){
                        if (data.code == 200) {
                            $(obj).parents("tr").find(".product-brand-manage").prepend('<a style="text-decoration:none" onClick="member_start(this,'+id+')" href="javascript:;" title="启用"><i class="Hui-iconfont">&#xe6e1;</i></a>');
                            $(obj).parents("tr").find(".td-status").html('<span class="label label-defaunt radius">已停用</span>');
                            $(obj).remove();
                            layer.msg('已停用!',{icon: 5,time:1000});
                        } else {
                            layer.msg(data.msg,{icon: 2,time:1000});
                        }

                    },
                    error:function(data) {
                        console.log(data.msg);
                    },
                });
            });
        }

        /*启用*/
        function member_start(obj,id){
            if (checkAuth('paasAudit') == 0) {
                return false;
            };
            layer.confirm('确认要启用吗？',function(index){
                $.ajax({
                    type: 'POST',
                    url: '{{route('passStatus')}}',
                    data:{_token:_token,id:id,status:'1'},
                    dataType: 'json',
                    success: function(data){
                        if (data.code == 200) {
                            $(obj).parents("tr").find(".product-brand-manage").prepend('<a style="text-decoration:none" onClick="member_stop(this,'+id+')" href="javascript:;" title="停用"><i class="Hui-iconfont">&#xe631;</i></a>');
                            $(obj).parents("tr").find(".td-status").html('<span class="label label-success radius">已启用</span>');
                            $(obj).remove();
                            layer.msg('已启用!',{icon: 6,time:1000});
                        } else {
                            layer.msg(data.msg,{icon: 2,time:1000});
                        }

                    },
                    error:function(data) {
                        console.log(data.msg);
                    },
                });
            });
        }
        /*删除*/
        function system_category_del(obj,id){
            if (checkAuth('paasDel') == 0) {
                return false;
            };
            layer.confirm('确认要删除吗？',function(index){
                $.ajax({
                    type: 'POST',
                    url: '{{route('paasDel')}}',
                    data:{id:id,_token:_token},
                    dataType: 'json',
                    success: function(data){
                        if (data.code == 200) {
                            $(obj).parents("tr").remove();
                            layer.msg(data.msg,{icon:1,time:1000});
                        } else {
                            layer.msg(data.msg,{icon:5,time:1000});
                        }
                    },
                    error:function(data) {
                        console.log(data.msg);
                    },
                });
            });
        }
        /*批量删除*/
        function datadel() {
            if (checkAuth('paasDel') == 0) {
                return false;
            };
            var ids = [];
            $('input[name="ids"]:checked').each(function (j) {
                if (j >= 0) {
                    ids.push($(this).val());
                }
            });
            if (ids.length > 0) {
                layer.confirm('确认要删除吗？',function(index) {
                    $.ajax({
                        type:'post',
                        url:'{{route('paasDel')}}',
                        data:{ids:ids,_token:_token},
                        dataType:'json',
                        success:function (data) {
                            if (data.code == 200) {
                                window.location.reload();
                            } else {
                                layer.msg(data.msg,{icon:5,time:1000})
                            }
                        }
                    });
                });
            } else {
                layer.msg('请先选择再删除!~',{icon:5,time:1000})
            }
        }
    </script>
@endsection































