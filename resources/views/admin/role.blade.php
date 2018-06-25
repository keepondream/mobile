@extends('layouts.adminchild')
@section('title','角色管理')
@section('content')
    <nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 管理员管理 <span class="c-gray en">&gt;</span> 角色管理 <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
    <div class="page-container">
        <div class="cl pd-5 bg-1 bk-gray"> <span class="l"> <a href="javascript:;" onclick="datadel()" class="btn btn-danger radius"><i class="Hui-iconfont">&#xe6e2;</i> 批量删除</a> <a class="btn btn-primary radius" href="javascript:;" onclick="admin_role_add('添加角色','{{route('roleAdd')}}','800')"><i class="Hui-iconfont">&#xe600;</i> 添加角色</a> </span> <span class="r">共有数据：<strong>{{count($roles)}}</strong> 条</span> </div>
        <table class="table table-border table-bordered table-hover table-bg">
            <thead>
            <tr>
                <th scope="col" colspan="6">角色管理</th>
            </tr>
            <tr class="text-c">
                <th width="25"><input type="checkbox" value="" name=""></th>
                <th width="40">ID</th>
                <th width="200">角色名</th>
                <th>用户列表</th>
                <th width="300">描述</th>
                <th width="70">操作</th>
            </tr>
            </thead>
            <tbody>
            @if(count($roles) > 0)
                @foreach($roles as $role)
                    <tr class="text-c">
                        <td><input type="checkbox" value="{{$role->id}}" name="id"></td>
                        <td>{{$role->id}}</td>
                        <td>{{$role->name}}</td>
                        <td>
                            @if(count($role->hasManyAdminUsers) > 0)
                                @foreach($role->hasManyAdminUsers as $k => $adminUser)
                                    @if($k == 0)
                                        {{--<a href="#">--}}
                                            {{$adminUser->name}}
                                        {{--</a>--}}
                                    @else
                                        、
                                        {{--<a href="#">--}}
                                            {{$adminUser->name}}
                                        {{--</a>--}}
                                    @endif
                                @endforeach
                            @endif

                        </td>
                        <td>{{$role->desc}}</td>
                        <td class="f-14"><a title="编辑" href="javascript:;" onclick="admin_role_edit('角色编辑','{{route('roleAdd',['id'=>$role->id])}}','800')" style="text-decoration:none"><i class="Hui-iconfont">&#xe6df;</i></a> <a title="删除" href="javascript:;" onclick="admin_role_del(this,'{{$role->id}}')" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6e2;</i></a></td>
                    </tr>
                @endforeach
            @endif

            {{--<tr class="text-c">--}}
                {{--<td><input type="checkbox" value="" name=""></td>--}}
                {{--<td>2</td>--}}
                {{--<td>总编</td>--}}
                {{--<td><a href="#">张三</a></td>--}}
                {{--<td>具有添加、审核、发布、删除内容的权限</td>--}}
                {{--<td class="f-14"><a title="编辑" href="javascript:;" onclick="admin_role_edit('角色编辑','admin-role-add.html','2')" style="text-decoration:none"><i class="Hui-iconfont">&#xe6df;</i></a> <a title="删除" href="javascript:;" onclick="admin_role_del(this,'1')" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6e2;</i></a></td>--}}
            {{--</tr>--}}
            {{--<tr class="text-c">--}}
                {{--<td><input type="checkbox" value="" name=""></td>--}}
                {{--<td>3</td>--}}
                {{--<td>栏目主辑</td>--}}
                {{--<td><a href="#">李四</a>，<a href="#">王五</a></td>--}}
                {{--<td>只对所在栏目具有添加、审核、发布、删除内容的权限</td>--}}
                {{--<td class="f-14"><a title="编辑" href="javascript:;" onclick="admin_role_edit('角色编辑','admin-role-add.html','3')" style="text-decoration:none"><i class="Hui-iconfont">&#xe6df;</i></a> <a title="删除" href="javascript:;" onclick="admin_role_del(this,'1')" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6e2;</i></a></td>--}}
            {{--</tr>--}}
            {{--<tr class="text-c">--}}
                {{--<td><input type="checkbox" value="" name=""></td>--}}
                {{--<td>4</td>--}}
                {{--<td>栏目编辑</td>--}}
                {{--<td><a href="#">赵六</a>，<a href="#">钱七</a></td>--}}
                {{--<td>只对所在栏目具有添加、删除草稿等权利。</td>--}}
                {{--<td class="f-14"><a title="编辑" href="javascript:;" onclick="admin_role_edit('角色编辑','admin-role-add.html','4')" style="text-decoration:none"><i class="Hui-iconfont">&#xe6df;</i></a> <a title="删除" href="javascript:;" onclick="admin_role_del(this,'1')" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6e2;</i></a></td>--}}
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
        /*管理员-角色-添加*/
        function admin_role_add(title, url, w, h) {
            if (checkAuth('roleAdd') == 0) {
                return false;
            };
            layer_show(title, url, w, h);
        }

        /*管理员-角色-编辑*/
        function admin_role_edit(title, url, id, w, h) {
            if (checkAuth('roleAdd') == 0) {
                return false;
            };
            layer_show(title, url, w, h);
        }

        /*管理员-角色-删除*/
        function admin_role_del(obj, id) {
            if (checkAuth('roleDel') == 0) {
                return false;
            };
            layer.confirm('角色删除须谨慎，确认要删除吗？', function (index) {
                $.ajax({
                    type: 'POST',
                    url: '{{route('roleDel')}}',
                    data:{id:id,_token:_token},
                    dataType: 'json',
                    success: function (data) {
                        if (data.code == 200) {
                            $(obj).parents("tr").remove();
                            layer.msg(data.msg,{icon:1,time:1000});
                        } else {
                            layer.msg(data.msg,{icon:5,time:1000});
                        }
                    },
                    error: function (data) {
                        console.log(data.msg);
                    },
                });
            });
        }
        /*批量删除*/
        function datadel() {
            if (checkAuth('roleDel') == 0) {
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
                        url:'{{route('roleDel')}}',
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

