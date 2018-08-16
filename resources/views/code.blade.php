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
                <small>
                    {{$user->name}}
                </small>
            </div>
            <div class="col-xs-6 col-sm-3" style="line-height: 18px;font-size: 18px;">
                <h3 class="label label-secondary radius">当前等级:</h3>
                    <img src="{{\App\Common\Common::grade($user->grade)['img']}}" class="avatar radius size-S" style="border-radius: 0;margin-top: -5px;" title="{{\App\Common\Common::grade($user->grade)['grade']}}">
                    {{--{{\App\Common\Common::grade($user->grade)['grade']}}--}}
            </div>
            <div class="col-xs-6 col-sm-3" style="line-height: 18px;font-size: 18px;">
                <h3 class="label label-secondary radius">可用积分:</h3>
                <small id="usercredit">
                    {{$user->credit}}
                </small>
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
                                                    @if(!empty($brandval) && ($brandval == $brandonly->sign))
                                                        <option value="{{$brandonly->sign}}" selected="selected">{{$brandonly->name}}</option>
                                                    @else
                                                        <option value="{{$brandonly->sign}}">{{$brandonly->name}}</option>
                                                    @endif
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
                                                    if (!empty($brand[0]->sign) || !empty($brandval)) {
                                                        if (!empty($brandval)) {
                                                            $brands = \App\http\Model\Brand::where('sign',$brandval)->select(['id'])->get();
                                                        } else {
                                                            $brands = \App\http\Model\Brand::where('sign',$brand[0]->sign)->select(['id'])->get();
                                                        }
                                                        if (count($brands) > 0) {
                                                            $projects = $brands[0]->projects;
                                                            if (count($projects) > 0) {
                                                                foreach ($projects as $project) {
                                                                    if ($project->status == 1) {
                                                                       $tempCountProject++;
                                                                    } ?>
                                                                    <?php if (!empty($itemidval) && ($itemidval == $project->sign)) { ?>
                                                                        <option value="<?php echo $project->sign?>" selected="selected"><?php echo $project->name?></option>
                                                                    <?php } else { ?>
                                                                        <option value="<?php echo $project->sign?>" ><?php echo $project->name?></option>

                                                                    <?php } ?>
                                                               <?php }
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
                                                @if((!empty($brand[0]->sign) || !empty($brandval)) && (count(\App\Common\Common::isp((!empty($brandval) ? $brandval : $brand[0]->sign))) > 0))
                                                    @foreach(\App\Common\Common::isp((!empty($brandval) ? $brandval : $brand[0]->sign)) as $ispk => $ispv)
                                                        @if(!empty($ispval) && ($ispval == $ispk))
                                                            <option value="{{$ispk}}" selected="selected">{{$ispv}}</option>
                                                        @else
                                                            <option value="{{$ispk}}">{{$ispv}}</option>
                                                        @endif
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
                                                <?php if (!empty($provinceval)) {
                                                    $tempProvinces = \App\http\Model\Region::where('parent_id',0)->select(['code','name'])->get()->toArray();
                                                    foreach ($tempProvinces as $tempProvince) {
                                                        if ($provinceval == $tempProvince['code']) { ?>
                                                            <option value="<?php echo $tempProvince['code']?>" selected="selected"><?php echo $tempProvince['name']?></option>
                                                        <?php } else { ?>
                                                            <option value="<?php echo $tempProvince['code']?>" ><?php echo $tempProvince['name']?></option>
                                                        <?php }
                                                    }
                                                }?>
                                            </select>
                                        </span>
                                    </div>
                                    <div class="col-xs-6 col-sm-6"  style="padding-left: 10px;padding-right: 0px;" id="city">
                                        <span class="select-box">
                                            <select class="select" size="1" name="city">
                                                <option value="0" selected>--不限--</option>
                                                <?php if (!empty($provinceval) && !empty($cityval)) {
                                                $tempCitys = \App\http\Model\Region::where('parent_id',$provinceval)->select(['code','name'])->get()->toArray();
                                                foreach ($tempCitys as $tempCity) {
                                                if ($cityval == $tempCity['code']) { ?>
                                                <option value="<?php echo $tempCity['code']?>" selected="selected"><?php echo $tempCity['name']?></option>
                                                <?php } else { ?>
                                                <option value="<?php echo $tempCity['code']?>" ><?php echo $tempCity['name']?></option>
                                                <?php }
                                                }
                                                }?>
                                            </select>
                                        </span>
                                    </div>
                                </td>
                            </tr>
                            <tr class="text-c">
                                <th width="20%">排除号段</th>
                                <td>
                                    <input type="text" name="excludeno" placeholder=" 如：171.172.174.178 每个号段必须是前三位用小数点分隔" style="width:100%;" onkeyup="(this.v=function(){this.value=this.value.replace(/[^0-9.]+/,'');}).call(this)" onblur="this.v();" value="{{!empty($excludenoval) ? $excludenoval : ''}}">
                                </td>
                            </tr>
                            <tr class="text-c">
                                <th width="20%">获取数量</th>
                                <td style="position: relative;padding-top: 5px;">
                                    <input type="text" name="phonenum" placeholder=" 最大获取10条" style="width:100%;" onkeyup="(this.v=function(){this.value=this.value.replace(/[^0-9-]+/,'');if(this.value && (this.value > 10 || this.value == 0)){this.value = ''};}).call(this)" onblur="this.v();" value="{{!empty($phonenumval) ? $phonenumval : '1'}}">
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
            <table class="table table-border table-bg table-bordered">
                <thead>
                <tr class="text-c">
                    <th class="col-xs-3 col-sm-3" style="float: none;">手机号码</th>
                    <th class="col-xs-5 col-sm-5" style="float: none;">短信内容</th>
                    <th class="col-xs-4 col-sm-4" style="float: none;">状&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;态</th>
                </tr>
                </thead>
                <tbody id="mobile_sms_content">
                <tr class="text-c">
                    <td class="col-xs-12 col-sm-12" colspan="3" style="float: none;">~~暂无相关数据,请先获取~~</td>
                </tr>
                </tbody>
            </table>
        </div>
        <div class="row cl mt-20">
            <div class="panel panel-default mt-20">
                <div class="panel-header selected">消费记录</div>
                <div class="panel-body" style="display: block;">
                    <table class="table table-border table-bordered table-bg">
                        <thead>
                        <tr>
                            <th>订单号</th>
                            <th>手机号</th>
                            <th>短信内容</th>
                            <th>消费状态</th>
                            <th>消费时间</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(!empty($model) && (count($model) > 0))
                            @foreach($model as $value)
                                <tr>
                                    <td><code>{{$value->order_id}}</code></td>
                                    <td><code>{{$value->mobile}}</code></td>
                                    <td><code>{{$value->sms_content}}</code></td>
                                    <td><span class="label {{$value->is_sms == 1 ? 'label-success' : 'label-danger'}} radius">{{$value->is_sms == 1 ? '已消费' : '未消费'}}</span></td>
                                    <td>{{$value->created_at}}</td>
                                </tr>
                            @endforeach
                        @else
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
@endsection

@section('script')
    <script>
        var mobiletimer = '';
        var mobileindex = 0;
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

        var tempRedisProvince = '<?php echo !empty($provinceval) ? $provinceval : '';?>';

        if (!tempRedisProvince) {
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
        }


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

        //提交
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
                    modalalertdemo(data.msg);
                    if (data.code == 200) {
                        var tr = $('#GetMobileNoBtn').parent();
                        $('#GetMobileNoBtn').remove();
                        var str = '<a href="javascript:;" class="btn btn-sm btn-danger" onclick="window.location.reload()">刷新页面</a>';
                        tr.append(str);
                        //立即执行
                        mobile_get(data.data['order_id'],data.data['num']);
                        //定时执行
                        mobiletimer = window.setInterval(function () {
                            mobile_get(data.data['order_id'],data.data['num']);
                        },5000)
                    }
                });
            }
        });

        //获取手机号并填充
        function mobile_get(order_id,num) {
            mobileindex++;
            //获取订单号详情
            $.ajax({
                type:"post",
                url: "{{route('getAllMobildDetail')}}",
                data:{_token:_token,order_id:order_id},
                dataType:"json",//指定返回的格式
                success:function(data){
                    if (data.code == 200) {
                        if ((data.data['count'] >= num) && (data.data['clear'] == 1)) {
                            window.clearInterval(mobiletimer);
                        } else if (mobileindex >= 70) {
                            window.clearInterval(mobiletimer);
                        }
                        //清空
                        $('#mobile_sms_content').empty();
                        $('#usercredit').text(data.data['credit']);
                        var res = data.data['content'];
                        var str = '';
                        var tempContent = '';
                        var tempClass = '';
                        for (var i = 0; i < res.length; i++) {
                            if (mobileindex >= 70) {
                                if (res[i].status == 0) {
                                    tempContent = '超时未使用,所耗积分将5分钟内返还.';
                                    tempClass = 'danger';
                                } else {
                                    tempContent = res[i].content;
                                    tempClass = res[i].class;
                                }
                                str += '<tr class="text-c '+tempClass+'">' +
                                    '<td class="col-xs-3 col-sm-3" style="float: none;">'+res[i].mobile+'</td>' +
                                    '<td class="col-xs-5 col-sm-5" style="float: none;">'+res[i].sms_content+'</td>' +
                                    '<td class="col-xs-4 col-sm-4" style="float: none;">'+tempContent+'</td>' +
                                    '</tr>';
                            } else {
                                str += '<tr class="text-c '+res[i].class+'">' +
                                    '<td class="col-xs-3 col-sm-3" style="float: none;">'+res[i].mobile+'</td>' +
                                    '<td class="col-xs-5 col-sm-5" style="float: none;">'+res[i].sms_content+'</td>' +
                                    '<td class="col-xs-4 col-sm-4" style="float: none;">'+res[i].content+'</td>' +
                                    '</tr>';
                            }
                        }
                        $('#mobile_sms_content').append(str);
                    }
                }
            });


        }

    </script>
@endsection




