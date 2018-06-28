@extends('layouts.adminchild')
@section('title','权限管理')
@section('content')
    <nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 管理员管理 <span class="c-gray en">&gt;</span> 管理员列表 <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
    <div class="page-container">
        <form action="{{route('manager')}}" method="post" class="form form-horizontal" id="form-category-add">
            @csrf
        <div class="text-c"> 日期范围：
            <input type="text" onfocus="WdatePicker({ maxDate:'#F{$dp.$D(\'datemax\')||\'%y-%M-%d\'}' })" id="datemin" name="datemin" class="input-text Wdate" style="width:120px;">
            -
            <input type="text" onfocus="WdatePicker({ minDate:'#F{$dp.$D(\'datemin\')}',maxDate:'%y-%M-%d' })" id="datemax" name="datemax" class="input-text Wdate" style="width:120px;">
            <input type="text" class="input-text" style="width:250px" placeholder="输入管理员名称" id="" name="name">
            <button type="submit" class="btn btn-success"><i class="Hui-iconfont">&#xe665;</i> 搜用户</button>
        </div>
        </form>
        <div class="cl pd-5 bg-1 bk-gray mt-20"> <span class="l"><a href="javascript:;" onclick="datadel()" class="btn btn-danger radius"><i class="Hui-iconfont">&#xe6e2;</i> 批量删除</a> <a href="javascript:;" onclick="admin_add('添加管理员','{{route('managerAdd')}}','800','600')" class="btn btn-primary radius"><i class="Hui-iconfont">&#xe600;</i> 添加管理员</a></span> <span class="r">共有数据：<strong>{{count($adminUsers)}}</strong> 条</span> </div>
        <table class="table table-border table-bordered table-bg">
            <thead>
            <tr>
                <th scope="col" colspan="9">管理员列表</th>
            </tr>
            <tr class="text-c">
                <th width="25"><input type="checkbox" name="" value=""></th>
                <th width="40">ID</th>
                <th width="150">登录名</th>
                <th width="90">手机</th>
                <th width="150">邮箱</th>
                <th>角色</th>
                <th width="130">加入时间</th>
                <th width="100">是否已启用</th>
                <th width="100">操作</th>
            </tr>
            </thead>
            <tbody>
            @if(count($adminUsers) > 0)
                @foreach($adminUsers as $adminUser)
                    <tr class="text-c">
                        <td><input type="checkbox" value="{{$adminUser->id}}" name="id"></td>
                        <td>{{$adminUser->id}}</td>
                        <td>{{$adminUser->name}}</td>
                        <td>{{$adminUser->mobile}}</td>
                        <td>{{$adminUser->email}}</td>
                        <td>{{$adminUser->hasOneRoles->name}}</td>
                        <td>{{$adminUser->created_at}}</td>
                        @if($adminUser->status == 1)
                        <td class="td-status"><span class="label label-success radius">已启用</span></td>
                        <td class="td-manage"><a style="text-decoration:none" onClick="admin_stop(this,'{{$adminUser->id}}')" href="javascript:;" title="停用"><i class="Hui-iconfont">&#xe631;</i></a> <a title="编辑" href="javascript:;" onclick="admin_edit('管理员编辑','{{route('managerAdd',['id'=>$adminUser->id])}}','1','800','600')" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6df;</i></a> <a title="删除" href="javascript:;" onclick="admin_del(this,'{{$adminUser->id}}')" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6e2;</i></a></td>
                        @else
                        <td class="td-status"><span class="label radius">已停用</span></td>
                        <td class="td-manage"><a style="text-decoration:none" onClick="admin_start(this,'{{$adminUser->id}}')" href="javascript:;" title="启用"><i class="Hui-iconfont">&#xe615;</i></a> <a title="编辑" href="javascript:;" onclick="admin_edit('管理员编辑','{{route('managerAdd',['id'=>$adminUser->id])}}','2','800','600')" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6df;</i></a> <a title="删除" href="javascript:;" onclick="admin_del(this,'{{$adminUser->id}}')" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6e2;</i></a></td>
                        @endif


                    </tr>
                @endforeach
            @endif

            {{--<tr class="text-c">--}}
                {{--<td><input type="checkbox" value="2" name=""></td>--}}
                {{--<td>2</td>--}}
                {{--<td>zhangsan</td>--}}
                {{--<td>13000000000</td>--}}
                {{--<td>admin@mail.com</td>--}}
                {{--<td>栏目编辑</td>--}}
                {{--<td>2014-6-11 11:11:42</td>--}}
                {{--<td class="td-status"><span class="label radius">已停用</span></td>--}}
                {{--<td class="td-manage"><a style="text-decoration:none" onClick="admin_start(this,'10001')" href="javascript:;" title="启用"><i class="Hui-iconfont">&#xe615;</i></a> <a title="编辑" href="javascript:;" onclick="admin_edit('管理员编辑','admin-add.html','2','800','500')" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6df;</i></a> <a title="删除" href="javascript:;" onclick="admin_del(this,'1')" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6e2;</i></a></td>--}}
            {{--</tr>--}}
            </tbody>
        </table>
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
        /*
            参数解释：
            title	标题
            url		请求的url
            id		需要操作的数据id
            w		弹出层宽度（缺省调默认值）
            h		弹出层高度（缺省调默认值）
        */
        /*管理员-增加*/
        function admin_add(title,url,w,h){
            if (checkAuth('managerAdd') == 0) {
                return false;
            };
            layer_show(title,url,w,h);
        }
        /*管理员-删除*/
        function admin_del(obj,id){
            if (checkAuth('managerDel') == 0) {
                return false;
            };
            layer.confirm('确认要删除吗？',function(index){
                $.ajax({
                    type: 'POST',
                    url: '{{route('managerDel')}}',
                    data:{id:id,_token:_token},
                    dataType: 'json',
                    success: function(data){
                        if (data.code == 200) {
                            $(obj).parents("tr").remove();
                            layer.msg('已删除!',{icon:1,time:1000});
                        } else {
                            layer.msg(data.msg,{icon:2,time:1000});
                        }
                    },
                    error:function(data) {
                        console.log(data.msg);
                    },
                });
            });
        }

        /*管理员-编辑*/
        function admin_edit(title,url,id,w,h){
            if (checkAuth('managerAdd') == 0) {
                return false;
            };
            layer_show(title,url,w,h);
        }
        /*管理员-停用*/
        function admin_stop(obj,id){
            if (checkAuth('managerAudit') == 0) {
                return false;
            };
            layer.confirm('确认要停用吗？',function(index){
                //此处请求后台程序，下方是成功后的前台处理……
                $.ajax({
                    type:'post',
                    url:'{{route('managerStatus')}}',
                    data:{id:id,status:0,_token:_token},
                    dataType:'json',
                    success:function (data) {
                        if (data.code == 200) {
                            layer.msg('已停用!',{icon:5,time:1000});
                            $(obj).parents("tr").find(".td-manage").prepend('<a onClick="admin_start(this,'+id+')" href="javascript:;" title="启用" style="text-decoration:none"><i class="Hui-iconfont">&#xe615;</i></a>');
                            $(obj).parents("tr").find(".td-status").html('<span class="label radius">已停用</span>');
                            $(obj).remove();
                        } else {
                            layer.msg(data.msg,{icon: 2,time:1000});
                        }
                    }
                });


            });
        }

        /*管理员-启用*/
        function admin_start(obj,id){
            if (checkAuth('managerAudit') == 0) {
                return false;
            };
            layer.confirm('确认要启用吗？',function(index){
                //此处请求后台程序，下方是成功后的前台处理……
                $.ajax({
                    type:'post',
                    url:'{{route('managerStatus')}}',
                    data:{id:id,status:1,_token:_token},
                    dataType:'json',
                    success:function (data) {
                        if (data.code == 200) {
                            layer.msg('已启用!',{icon:6,time:1000});
                            $(obj).parents("tr").find(".td-manage").prepend('<a onClick="admin_stop(this,'+id+')" href="javascript:;" title="停用" style="text-decoration:none"><i class="Hui-iconfont">&#xe631;</i></a>');
                            $(obj).parents("tr").find(".td-status").html('<span class="label label-success radius">已启用</span>');
                            $(obj).remove();
                        } else {
                            layer.msg(data.msg,{icon: 2,time:1000});
                        }
                    }
                });
            });
        }
        /*批量删除*/
        function datadel() {
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
                        url:'{{route('managerDel')}}',
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
                datemin:"required",
                datemax:"required",
                name:"required",
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
    </script>
@endsection

