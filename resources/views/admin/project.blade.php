@extends('layouts.adminchild')
@section('title','项目管理')
@section('content')
    <nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页
        <span class="c-gray en">&gt;</span>
        产品管理
        <span class="c-gray en">&gt;</span>
        项目管理
        <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a>
    </nav>
    <div class="page-container">
        <div class="text-c">
            <form action="{{route('project')}}" method="post" class="form form-horizontal" id="form-category-add">
                @csrf
                <div>
                    <div style="margin:auto;position: relative;width: 520px;">
                        <input type="text" name="searchData" id="searchData" placeholder="项目名称、id" style="width:250px" class="input-text">
                        <button name="" id="" class="btn btn-success" type="submit" ><i class="Hui-iconfont">&#xe665;</i> 搜索</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="cl pd-5 bg-1 bk-gray mt-20">
		<span class="l">
		<a href="javascript:;" onclick="datadel()" class="btn btn-danger radius"><i class="Hui-iconfont">&#xe6e2;</i> 批量删除</a>
		<a class="btn btn-primary radius" onclick="system_category_add('添加项目','{{route('projectAdd')}}','',500)" href="javascript:;"><i class="Hui-iconfont">&#xe600;</i> 添加项目</a>
		</span>
            <span class="r">共有数据：<strong>{{!empty($count) ? $count : 0}}</strong> 条</span>
        </div>
        <div class="mt-20">
            <table class="table table-border table-bordered table-hover table-bg table-sort">
                <thead>
                <tr class="text-c">
                    <th width="25"><input type="checkbox" name="" value=""></th>
                    <th width="80">ID</th>
                    <th width="100">项目名称</th>
                    <th width="100">项目编号</th>
                    <th >项目描述</th>
                    <th width="100">所属平台</th>
                    <th width="80">排序</th>
                    <th width="80">状态</th>
                    <th width="100">操作</th>
                </tr>
                </thead>
                <tbody>
                @if(!empty($projects) && (count($projects) > 0))
                    @foreach($projects as $k => $v)
                        <tr class="text-c">
                            <td><input type="checkbox" name="id" value="{{$v['id']}}"></td>
                            <td>{{$v['id']}}</td>
                            <td>{{$v['name']}}</td>
                            <td>{{$v['sign']}}</td>
                            <td>{{$v['desc']}}</td>
                            <td>{{$v->brand['name']}}</td>
                            <td>{{$v['sort']}}</td>
                            @if($v->status == 1)
                                <td class="td-status"><span class="label label-success radius">已启用</span></td>
                                <td class="f-14 product-brand-manage">
                                    <a style="text-decoration:none" onClick="project_stop(this,'{{$v->id}}')" href="javascript:;" title="停用"><i class="Hui-iconfont">&#xe631;</i></a>
                                    <a style="text-decoration:none" onClick="system_category_edit('项目编辑','{{route('projectAdd',['id'=>$v->id])}}','{{$v->id}}','',550)" href="javascript:;" title="编辑"><i class="Hui-iconfont">&#xe6df;</i></a>
                                    <a style="text-decoration:none" class="ml-5" onClick="system_category_del(this,'{{$v->id}}')" href="javascript:;" title="删除"><i class="Hui-iconfont">&#xe6e2;</i></a>
                                </td>
                            @else
                                <td class="td-status"><span class="label radius">已停用</span></td>
                                <td class="f-14 product-brand-manage">
                                    <a style="text-decoration:none" onClick="project_start(this,'{{$v->id}}')" href="javascript:;" title="启用"><i class="Hui-iconfont">&#xe6e1;</i></a>
                                    <a style="text-decoration:none" onClick="system_category_edit('项目编辑','{{route('projectAdd',['id'=>$v->id])}}','{{$v->id}}','',550)" href="javascript:;" title="编辑"><i class="Hui-iconfont">&#xe6df;</i></a>
                                    <a style="text-decoration:none" class="ml-5" onClick="system_category_del(this,'{{$v->id}}')" href="javascript:;" title="删除"><i class="Hui-iconfont">&#xe6e2;</i></a>
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
        var _token = $("meta[name='csrf-token']").attr('content');
        $('.table-sort').dataTable({
            "aaSorting": [[ 1, "asc" ]],//默认第几个排序
            "bStateSave": false,//状态保存
            "aoColumnDefs": [
                // {"bVisible": false, "aTargets": [ 1 ]}, //控制列的隐藏显示
                {"orderable":false,"aTargets":[0,2,3,4,5,7,8]}// 制定列不参与排序
            ]
        });
        /*添加*/
        function system_category_add(title,url,w,h){
            if (checkAuth('projectAdd') == 0) {
                return false;
            };
            layer_show(title,url,w,h);
        }
        /*编辑*/
        function system_category_edit(title,url,id,w,h){
            if (checkAuth('projectAdd') == 0) {
                return false;
            };
            layer_show(title,url,w,h);
        }
        /*删除*/
        function system_category_del(obj,id){
            if (checkAuth('projectDel') == 0) {
                return false;
            };
            layer.confirm('确认要删除吗？',function(index){
                $.ajax({
                    type: 'POST',
                    url: '{{route('projectDel')}}',
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
            if (checkAuth('projectDel') == 0) {
                return false;
            };
            var ids = [];
            $('input[name="id"]:checked').each(function (j) {
                if (j >= 0) {
                    ids.push($(this).val());
                }
            });
            if (ids.length > 0) {
                layer.confirm('确认要删除吗？',function(index) {
                    $.ajax({
                        type:'post',
                        url:'{{route('projectDel')}}',
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

        //搜索验证
        $("#form-category-add").validate({
            rules:{
                searchData:"required",
            },
            onkeyup:false,
            focusCleanup:true,
            success:"valid",
            submitHandler:function(form){
                return true;
                // $(form).ajaxSubmit(function (data) {
                //     if (data.code != 200) {
                //         layer.msg(data.msg,{icon:2,time:1000})
                //     } else {
                //         layer.msg(data.msg,{icon:1,time:1000})
                //     }
                // });
                // setTimeout(function () {
                //     var index = parent.layer.getFrameIndex(window.name);
                //     // parent.$('.btn-refresh').click();
                //     parent.window.location.reload();
                //     parent.layer.close(index);
                // },1000);

            }
        });

        /*停用*/
        function project_stop(obj,id){
            if (checkAuth('projectAudit') == 0) {
                return false;
            };
            layer.confirm('确认要停用吗？',function(index){
                $.ajax({
                    type: 'POST',
                    url: '{{route('projectStatus')}}',
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
        function project_start(obj,id){
            if (checkAuth('projectAudit') == 0) {
                return false;
            };
            layer.confirm('确认要启用吗？',function(index){
                $.ajax({
                    type: 'POST',
                    url: '{{route('projectStatus')}}',
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

    </script>
@endsection

