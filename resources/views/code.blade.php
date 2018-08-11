@extends('layouts.app')

@section('content')
    <style>
        .bgc {
            background-color: #f7f7f9;
            border: 1px solid #e1e1e8;
        }
        .header {
            border-color: #ddd;
            background-color: #f5f5f5;
            color: #444;
            border-bottom: solid 1px transparent;
            padding: 8px 15px;
            font-size: 18px;
            font-weight: 700;
        }
    </style>
    <div class="container" style="border: none;">
        <div class="row cl">
            <div class="header col-xs-12 col-sm-12 mb-10">基础信息</div>
            <div class="col-xs-6 col-sm-3" style="line-height: 18px;font-size: 18px;">
                <h3 class="label label-secondary radius">会员姓名:</h3>
                {{$user->name}}
            </div>
            <div class="col-xs-6 col-sm-3" style="line-height: 18px;font-size: 18px;">
                <h3 class="label label-secondary radius">当前等级:</h3>
                    <img src="{{\App\Common\Common::grade($user->grade)['img']}}" class="avatar radius size-S" style="border-radius: 0;margin-top: -5px;" title="{{\App\Common\Common::grade($user->grade)['grade']}}">
                    {{--{{\App\Common\Common::grade($user->grade)['grade']}}--}}
            </div>
            <div class="col-xs-6 col-sm-3" style="line-height: 18px;font-size: 18px;">
                <h3 class="label label-secondary radius">可用积分:</h3>
                {{$user->credit}}
            </div>
            <div class="col-xs-6 col-sm-3" style="line-height: 18px;font-size: 18px;">

            </div>
        </div>

        <div class="row cl mt-20">
            <div class="header col-xs-12 col-sm-12 mb-10">获取手机号码</div>
            <div class="col-md-12">
                {{--左侧区域--}}
                <div class="col-xs-12 col-sm-6">
                    <form action="{{route('getMobile')}}" method="post" class="form form-horizontal" id="form-get-mobile">
                        @csrf
                        <table class="table table-border table-bg table-bordered table-hover">
                        <tbody>
                        <tr class="text-c">
                            <th width="20%">品&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;牌</th>
                            <td>
                                <span class="select-box">
                                    <select class="select" size="1" name="brandsign" id="brandsignselect">
                                        @if(!empty($brand) && (count($brand) > 0))
                                            @foreach($brand as $brandonly)
                                            <option value="{{$brandonly->sign}}">{{$brandonly->name}}</option>
                                            @endforeach
                                        @else
                                            <option value="" selected>--暂未开放--</option>
                                        @endif
                                    </select>
                                </span>
                            </td>
                        </tr>
                        <tr class="text-c">
                            <th width="20%">项&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;目</th>
                            <td>
                                <span class="select-box">
                                    <select class="select" size="1" name="itemid" id="itemid">
                                        @if(!empty($brand) && (count($brand) > 0))
                                           <?php
                                                $tempCountProject = 0;
                                                if (!empty($brand[0]->sign)) {
                                                    $brands = \App\http\Model\Brand::where('sign',$brand[0]->sign)->select(['id'])->get();
                                                    if (count($brands) > 0) {
                                                       $projects = $brands[0]->projects;
                                                       if (count($projects) > 0) {
                                                           foreach ($projects as $project) {
                                                               if ($project->status == 1) {
                                                                   $tempCountProject++;
                                                               }
                                                               ?>
                                                               <option value="<?php echo $project->sign?>" ><?php echo $project->name?></option>
                                                           <?php
                                                           }
                                                       }
                                                    }
                                                };
                                                if ($tempCountProject == 0) { ?>
                                                    <option value="" selected>--暂未开放--</option>
                                                <?php }
                                            ?>
                                        @else
                                            <option value="" selected>--暂未开放--</option>
                                        @endif
                                    </select>
                                </span>
                            </td>
                        </tr>
                        <tr class="text-c">
                            <th width="20%">运 营 商</th>
                            <td>
                                <span class="select-box">
                                    <select class="select" size="1" name="isp" id="ispsignselect">
                                        @if(!empty($brand) && (count($brand) > 0))
                                            @if(!empty($brand[0]->sign) && (count(\App\Common\Common::isp($brand[0]->sign)) > 0))
                                                @foreach(\App\Common\Common::isp($brand[0]->sign) as $ispk => $ispv)
                                                    <option value="{{$ispk}}">{{$ispv}}</option>
                                                @endforeach
                                            @else
                                                <option value="" selected>--暂未开放--</option>
                                            @endif
                                        @else
                                            <option value="" selected>--暂未开放--</option>
                                        @endif
                                    </select>
                                </span>
                            </td>
                        </tr>
                        <tr class="text-c">
                            <th width="20%">归 属 地</th>
                            <td>
                                <div class="col-xs-6 col-sm-6" style="padding-left: 0px;padding-right: 0px;" id="area">
                                    <span class="select-box">
                                        <select class="select" size="1" name="province">
                                            <option value="0" selected>--不限--</option>
                                        </select>
                                    </span>
                                </div>
                                <div class="col-xs-6 col-sm-6"  style="padding-left: 10px;padding-right: 0px;" id="city">
                                    <span class="select-box">
                                        <select class="select" size="1" name="city">
                                            <option value="0" selected>--不限--</option>
                                        </select>
                                    </span>
                                </div>
                            </td>
                        </tr>
                        <tr class="text-c">
                            <th width="20%">排除号段</th>
                            <td>
                                <input type="text" name="excludeno" placeholder=" 如：171.172.174.178 每个号段必须是前三位用小数点分隔" style="width:100%;" onkeyup="(this.v=function(){this.value=this.value.replace(/[^0-9.]+/,'');}).call(this)" onblur="this.v();">
                            </td>
                        </tr>
                        <tr class="text-c">
                            <th width="20%">获取数量</th>
                            <td style="position: relative;padding-top: 5px;">
                                <input type="text" name="phonenum" placeholder=" 最大获取10条" style="width:100%;" onkeyup="(this.v=function(){this.value=this.value.replace(/[^0-9-]+/,'');if(this.value && (this.value > 10 || this.value == 0)){this.value = ''};}).call(this)" onblur="this.v();">
                            </td>
                        </tr>
                        <tr class="text-c">
                            <th width="20%"></th>
                            <td>
                                <button type="submit" id="GetMobileNoBtn" class="btn btn-sm btn-success">获取手机号</button>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    </form>
                </div>
                {{--右侧区域--}}
                <div class="col-xs-12 col-sm-6">
                    <div class="box">
                        <div class="box-body">
                            <dl>
                                <dt>为什么接收不到短信，怎么应对？</dt>
                                <dd>1、【对方的短信格式有变化】将收不到短信的手机号提供给客服重新设置项目；</dd>
                                <dd>2、【对方对号段、归属地、运营商有限制】搞清楚对方要求并重新设置号码筛选规则；</dd>
                                <dd>3、【号码已被使用过】拉黑号码并重新获取；</dd>
                                <dd>4、【项目选择错误】请重新选择正确的项目；</dd>
                                <dd>5、【其他原因】拉黑号码并重新获取；</dd>
                            </dl>
                        </div>
                    </div>
                    <div class="box">
                        <div class="box-body">
                            <dl>
                                <dt>如何计费，没有收到短信会扣费吗？</dt>
                                <dd>每个项目每接收或发送一条短信计费一次，具体价格请参考项目信息里的价格</dd>
                                <dd>本平台是成功接收或发送短信才会计费，未成功不扣费；</dd>
                            </dl>
                        </div>
                    </div>
                    <div class="box">
                        <div class="box-body">
                            <dl>
                                <dt>什么是项目？</dt>
                                <dd>我们按不同的短信类别分为不同的项目，每个项目对应了可以接收的相应短信。</dd>
                                <dd>比如短信内容为：【熊猫社区】您的验证码是969939，请在10分钟内正确输入，请勿外泄。</dd>
                                <dd>该短信对应的项目名称为：熊猫社区</dd>
                            </dl>
                        </div>
                    </div>
                    <div class="box">
                        <div class="box-body">
                            <dl>
                                <dt>没有我要的项目怎么办？</dt>
                                <dd>如果无法找到你要的项目，请联系客服添加；</dd>
                                <dd>联系客服时，最好能提供一条曾经收到过的短信原文，以便我们更快的为你添加项目；</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row cl mt-20">
            <div class="header col-xs-12 col-sm-12 mb-10">获取短信</div>
        </div>
    </div>
@endsection

@section('script')
    <script>

        $("#brandsignselect").change(function() {
            if ($('#brandsignselect').val()) {
                //获取项目
                $.ajax({
                    type:"post",
                    url:"{{route('getProject')}}",
                    data:{_token:_token,sign:$("#brandsignselect").val()},
                    dataType:"json",//指定返回的格式
                    success:function(data){
                        if (data.code == 200) {
                            //清空option
                            $("#itemid option").remove();
                            var dataindex = 0;
                            for(var i=0;i<data.data.length;i++){
                                if (data.data[i].status == 1) {
                                    dataindex++;
                                    $("<option value='"+data.data[i].sign+"'>"+data.data[i].name+"</option>").appendTo($("#itemid"));//添加下拉列表
                                }
                            }
                            if (dataindex == 0) {
                                $("<option value=''>--暂未开放--</option>").appendTo($("#itemid"));
                            }
                        }
                    }
                });
                //获取运营商
                $.ajax({
                    type:"post",
                    url: "{{route('getisp')}}",
                    data:{_token:_token,sign:$("#brandsignselect").val()},
                    dataType:"json",//指定返回的格式
                    success:function(data){
                        if (data.code == 200) {
                            //清空option
                            $("#ispsignselect option").remove();
                            for(var i=0;i<data.data['isp'].length;i++){
                                $("<option value='"+i+"'>"+data.data['isp'][i]+"</option>").appendTo($("#ispsignselect"));//添加下拉列表
                            }
                        }
                    }
                });
            } else {
                $("#ispsignselect option").remove().appendTo();
                $("<option value=''>--暂未开放--</option>").appendTo($("#ispsignselect"));
                $("#itemid option").remove().appendTo();
                $("<option value=''>--暂未开放--</option>").appendTo($("#itemid"));
            }
        });

        //清空还原
        function clearOptions() {
            $("#ispsignselect option").remove().appendTo();
            $("<option value=''>--暂未开放--</option>").appendTo($("#ispsignselect"));
        }
        //一级
        $.ajax({
            type:"post",
            url: "{{route('citySelect')}}",
            data:{_token:_token,parent_id:0},
            dataType:"json",//指定返回的格式
            success:function(data){
                for(var i=0;i<data.data.length;i++){
                    var code=data.data[i].code//返回对象的一个属性
                    var name=data.data[i].name;
                    var status = '';
                    if (area && (code == area)) {
                        status = 'selected="selected"';
                    }
                    $("<option value='"+code+"' "+status+">"+name+"</option>").appendTo($("#area select"));//添加下拉列表
                }
            }
        });
        //二级
        $("#area select").change(function() {
            //清空下面两个子下拉列表(option中value值大于0的删除)
            $("#city option:gt(0)").remove();
            $("#county option:gt(0)").remove();
            if ($("#area select").val() == 0) {
                return;//没有选择的就不去调用
            }
            $.ajax({
                type:"post",
                url: "{{route('citySelect')}}",
                data:{_token:_token,parent_id:$("#area select").val()},
                dataType:"json",//指定返回的格式
                success:function(data){
                    for(var i=0;i<data.data.length;i++){
                        var code=data.data[i].code//返回对象的一个属性
                        var name=data.data[i].name;
                        var status = '';
                        if (city && (code == city)) {
                            status = 'selected="selected"';
                        }
                        $("<option value='"+code+"' "+status+">"+name+"</option>").appendTo($("#city select"));//添加下拉列表
                    }
                }
            });
        });

        $("#form-get-mobile").validate({
            rules:{
                phonenum:"required",
                url:"required",
            },
            onkeyup:false,
            focusCleanup:true,
            success:"valid",
            submitHandler:function(form){
                $(form).ajaxSubmit(function (data) {
                    // if (data.code != 200) {
                    //     layer.msg(data.msg,{icon:2,time:1000})
                    // } else {
                    //     layer.msg(data.msg,{icon:1,time:1000})
                    // }
                });
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


