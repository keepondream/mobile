﻿@extends('layouts.adminchild')
@section('title','菜单管理')
@section('content')
    <nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 会员管理 <span class="c-gray en">&gt;</span> 会员列表 <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
    <div class="page-container">
        <form action="{{route('member')}}" method="post" class="form form-horizontal" id="form-category-add">
            @csrf
            <div class="text-c"> 日期范围：
            <input type="text" onfocus="WdatePicker({ maxDate:'#F{$dp.$D(\'datemax\')||\'%y-%M-%d\'}' })" id="datemin" name="datemin" class="input-text Wdate" style="width:120px;">
            -
            <input type="text" onfocus="WdatePicker({ minDate:'#F{$dp.$D(\'datemin\')}',maxDate:'%y-%M-%d' })" id="datemax" name="datemax" class="input-text Wdate" style="width:120px;">
            <input type="text" class="input-text" style="width:250px" placeholder="输入会员名称、电话、邮箱" id="" name="name">
            <button type="submit" class="btn btn-success radius" ><i class="Hui-iconfont">&#xe665;</i> 搜用户</button>
        </div>
        </form>
        <div class="cl pd-5 bg-1 bk-gray mt-20"> <span class="l"><a href="javascript:;" onclick="datadel()" class="btn btn-danger radius"><i class="Hui-iconfont">&#xe6e2;</i> 批量删除</a> <a href="javascript:;" onclick="member_add('添加用户','{{route('memberAdd')}}','','610')" class="btn btn-primary radius"><i class="Hui-iconfont">&#xe600;</i> 添加用户</a></span> <span class="r">共有数据：<strong>{{count($members)}}</strong> 条</span> </div>
        <div class="mt-20">
            <table class="table table-border table-bordered table-hover table-bg table-sort">
                <thead>
                <tr class="text-c">
                    <th width="25"><input type="checkbox" name="" value=""></th>
                    <th width="80">ID</th>
                    <th width="100">用户名</th>
                    <th width="40">性别</th>
                    <th width="90">手机</th>
                    <th width="150">邮箱</th>
                    <th width="">地址</th>
                    <th width="130">加入时间</th>
                    <th width="70">状态</th>
                    <th width="100">操作</th>
                </tr>
                </thead>
                <tbody>
                @if(count($members) > 0)
                    @foreach($members as $user)
                        <tr class="text-c">
                            <td><input type="checkbox" value="{{$user->id}}" name="id"></td>
                            <td>{{$user->id}}</td>
                            <td><u style="cursor:pointer" class="text-primary" onclick="member_show('{{$user->name}}','member-show.html','{{$user->id}}','360','400')">{{$user->name}}</u></td>
                            <td>{{($user->sex) == 1 ? '男' : (($user->sex) == 2 ? '女': '保密')}}</td>
                            <td>{{$user->mobile}}</td>
                            <td>{{$user->email}}</td>
                            <td class="text-l">{{!empty($user->hasOneArea->name) ? $user->hasOneArea->name : ''}}{{!empty($user->hasOneCity->name) ? '-'.$user->hasOneCity->name : ''}}{{!empty($user->hasOneCounty->name) ? '-'.$user->hasOneCounty->name : ''}}</td>
                            <td>{{$user->created_at}}</td>
                            @if($user->status == 1)
                                <td class="td-status"><span class="label label-success radius">已启用</span></td>
                                <td class="td-manage"><a style="text-decoration:none" onClick="member_stop(this,'{{$user->id}}')" href="javascript:;" title="停用"><i class="Hui-iconfont">&#xe631;</i></a> <a title="编辑" href="javascript:;" onclick="member_edit('编辑','{{route('memberAdd',['id'=>$user->id])}}','4','','610')" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6df;</i></a> <a style="text-decoration:none" class="ml-5" onClick="change_password('修改密码','{{route('changePassword',['id'=>$user->id])}}','{{$user->id}}','600','270')" href="javascript:;" title="修改密码"><i class="Hui-iconfont">&#xe63f;</i></a> <a title="删除" href="javascript:;" onclick="member_del(this,'{{$user->id}}')" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6e2;</i></a></td>
                            @else
                                <td class="td-status"><span class="label radius">已停用</span></td>
                                <td class="td-manage"><a style="text-decoration:none" onClick="member_start(this,'{{$user->id}}')" href="javascript:;" title="启用"><i class="Hui-iconfont">&#xe631;</i></a> <a title="编辑" href="javascript:;" onclick="member_edit('编辑','{{route('memberAdd',['id'=>$user->id])}}','4','','610')" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6df;</i></a> <a style="text-decoration:none" class="ml-5" onClick="change_password('修改密码','{{route('changePassword',['id'=>$user->id])}}','{{$user->id}}','600','270')" href="javascript:;" title="修改密码"><i class="Hui-iconfont">&#xe63f;</i></a> <a title="删除" href="javascript:;" onclick="member_del(this,'{{$user->id}}')" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6e2;</i></a></td>
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
        $(function(){
            $('.table-sort').dataTable({
                "aaSorting": [[ 1, "desc" ]],//默认第几个排序
                "bStateSave": true,//状态保存
                "aoColumnDefs": [
                    //{"bVisible": false, "aTargets": [ 3 ]} //控制列的隐藏显示
                    {"orderable":false,"aTargets":[0,8,9]}// 制定列不参与排序
                ]
            });

        });
        /*用户-添加*/
        function member_add(title,url,w,h){
            if (checkAuth('memberAdd') == 0) {
                return false;
            };
            layer_show(title,url,w,h);
        }
        /*用户-查看*/
        function member_show(title,url,id,w,h){
            layer_show(title,url,w,h);
        }
        /*用户-停用*/
        function member_stop(obj,id){
            if (checkAuth('memberAudit') == 0) {
                return false;
            };
            layer.confirm('确认要停用吗？',function(index){
                $.ajax({
                    type: 'POST',
                    url: '{{route('memberStatus')}}',
                    data:{_token:_token,id:id,status:'0'},
                    dataType: 'json',
                    success: function(data){
                        if (data.code == 200) {
                            $(obj).parents("tr").find(".td-manage").prepend('<a style="text-decoration:none" onClick="member_start(this,'+id+')" href="javascript:;" title="启用"><i class="Hui-iconfont">&#xe6e1;</i></a>');
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

        /*用户-启用*/
        function member_start(obj,id){
            if (checkAuth('memberAudit') == 0) {
                return false;
            };
            layer.confirm('确认要启用吗？',function(index){
                $.ajax({
                    type: 'POST',
                    url: '{{route('memberStatus')}}',
                    data:{_token:_token,id:id,status:'1'},
                    dataType: 'json',
                    success: function(data){
                        if (data.code == 200) {
                            $(obj).parents("tr").find(".td-manage").prepend('<a style="text-decoration:none" onClick="member_stop(this,'+id+')" href="javascript:;" title="停用"><i class="Hui-iconfont">&#xe631;</i></a>');
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
        /*用户-编辑*/
        function member_edit(title,url,id,w,h){
            if (checkAuth('memberAdd') == 0) {
                return false;
            };
            layer_show(title,url,w,h);
        }
        /*密码-修改*/
        function change_password(title,url,id,w,h){
            if (checkAuth('memberChangePassword') == 0) {
                return false;
            };
            layer_show(title,url,w,h);
        }
        /*用户-删除*/
        function member_del(obj,id){
            if (checkAuth('memberDel') == 0) {
                return false;
            };
            layer.confirm('确认要删除吗？',function(index){
                $.ajax({
                    type: 'POST',
                    url: '',
                    dataType: 'json',
                    success: function(data){
                        $(obj).parents("tr").remove();
                        layer.msg('已删除!',{icon:1,time:1000});
                    },
                    error:function(data) {
                        console.log(data.msg);
                    },
                });
            });
        }
        /*批量删除*/
        function datadel() {
            if (checkAuth('memberDel') == 0) {
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
                        url:'{{route('memberDel')}}',
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

