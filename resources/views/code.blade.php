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
                {{\App\Common\Common::grade($user->grade)['grade']}}
                <img src="{{\App\Common\Common::grade($user->grade)['img']}}" class="avatar radius size-S" style="border-radius: 0;">

            </div>
            <div class="col-xs-6 col-sm-3" style="line-height: 18px;font-size: 18px;">
                <h3 class="label label-secondary radius">可用积分:</h3>
                {{$user->credit}}
            </div>
            <div class="col-xs-6 col-sm-3" style="line-height: 18px;font-size: 18px;">

            </div>
        </div>

        <div class="row cl mt-20">
            <div class="header col-xs-12 col-sm-12 mb-10">短信验证码服务</div>
            <div class="col-md-12">
                <div class="col-xs-12 col-sm-6">
                    <table class="table table-border table-bg table-bordered table-hover">
                        <thead>
                        <tr class="text-c">
                            <th width="20%">品&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;牌</th>
                            <th>
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
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr class="text-c">
                            <th width="20%">运 营 商</th>
                            <th>
                                <span class="select-box">
                                    <select class="select" size="1" name="ispsign" id="ispsignselect">
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
                            </th>
                        </tr>
                        <tr class="active"><th>.active</th><td>悬停在行</td></tr>
                        <tr class="success"><th>.success</th><td>成功或积极</td></tr>
                        <tr class="warning"><th>.warning</th><td>警告或出错</td></tr>
                        <tr class="danger"><th>.danger</th><td>危险</td></tr>
                        </tbody>
                    </table>
                    <div>
                        <div class="col-xs-6 col-sm-2" style="padding: 4px 5px;line-height: 14px;">线路分支</div>
                        <div class="col-xs-6 col-sm-2">

                        </div>
                    </div>
                </div>
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
                                <dt>如何查询我要做的项目？</dt>
                                <dd>在项目查询的关键词输入框中输入“熊猫”或者“熊猫社区”，系统将会查询出项目名称中包含该词的全部项目供你选择；</dd>
                                <dd>在选择你要的项目后，系统将显示对应的项目编号、单价等修改信息；</dd>
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
                <div class="box box-info">

                    <div class="form-horizontal">
                        <div class="box-body">
                            <div class="row form-group">
                                <label for="MobileItemName" class="col-sm-3 control-label">短信项目：</label>
                                <div class="col-sm-7">
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="MobileItemName" placeholder="请点击右侧按钮查询项目" disabled="">
                                        <span class="input-group-btn">
<button type="button" id="seachitembtn" class="btn btn-info btn-flat">选择项目</button>
</span>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="input-group">
<span class="input-group-btn">
<a class="btn btn-success btn-flat" target="_blank" href="../helps.html">新手教程</a>
</span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="ISPList" class="col-sm-3 control-label">运营商：</label>
                                <div class="col-sm-9">
                                    <select class="form-control" id="ISPList">
                                        <option value="0">—不限—</option>
                                        <option value="2">联通</option>
                                        <option value="1">移动</option>
                                        <option value="3">电信</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="ProvinceList" class="col-sm-3 control-label">归属地：</label>
                                <div class="col-sm-4">
                                    <select class="form-control" id="ProvinceList">
                                        <option value="0">—不限—</option>
                                        <option value="110000">北京市</option><option value="120000">天津市</option><option value="130000">河北省</option><option value="140000">山西省</option><option value="150000">内蒙古自治区</option><option value="210000">辽宁省</option><option value="220000">吉林省</option><option value="230000">黑龙江省</option><option value="310000">上海市</option><option value="320000">江苏省</option><option value="330000">浙江省</option><option value="340000">安徽省</option><option value="350000">福建省</option><option value="360000">江西省</option><option value="370000">山东省</option><option value="410000">河南省</option><option value="420000">湖北省</option><option value="430000">湖南省</option><option value="440000">广东省</option><option value="450000">广西壮族自治区</option><option value="460000">海南省</option><option value="500000">重庆市</option><option value="510000">四川省</option><option value="520000">贵州省</option><option value="530000">云南省</option><option value="540000">西藏自治区</option><option value="610000">陕西省</option><option value="620000">甘肃省</option><option value="630000">青海省</option><option value="640000">宁夏回族自治区</option><option value="650000">新疆维吾尔自治区</option></select>
                                </div>
                                <div class="col-sm-5">
                                    <select class="form-control" id="CityList">
                                        <option value="0">—不限—</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="ExcludeNo" class="col-sm-3 control-label">排除号段：</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="ExcludeNo" placeholder="如：171.172.174.178">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="MobileNo" class="col-sm-3 control-label">手机号码：</label>
                                <div class="col-sm-3">
                                    <button class="btn" id="MobileNoCodeCopyBtn" data-clipboard-action="copy" data-clipboard-target="#MobileNo" style="display: none"></button>
                                    <input type="text" class="form-control" id="MobileNo" placeholder="请获取手机号..." data-toggle="tooltip" data-placement="bottom" title="点击自动复制">
                                </div>
                                <div class="col-sm-6">
                                    <div class="btn-group">
                                        <button type="button" id="GetMobileNoBtn" class="btn btn-sm btn-success">获取手机号</button>
                                        <button type="button" id="ReleaseMobileNoBtn" class="btn btn-sm btn-info">释放手机号</button>
                                        <button type="button" id="addIgnoreMobileNoBtn" class="btn btn-sm btn-warning" title="加入黑名单后将不会再次获取到该号码">加入黑名单</button>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="SMSContent" class="col-sm-3 control-label">短信内容：</label>
                                <div class="col-sm-9">
                                    <textarea class="form-control" id="SMSContent" placeholder="请将获取到的号码填写到你要完成验证的网站或APP，并触发对方发送短信，比如点击对方界面上的“获取验证码”按钮等。"></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="VerificationCode" class="col-sm-3 control-label">验证码：</label>
                                <div class="col-sm-3">
                                    <button class="btn" id="VerificationCodeCopyBtn" data-clipboard-action="copy" data-clipboard-target="#VerificationCode" style="display: none"></button>
                                    <input type="text" class="form-control" id="VerificationCode" data-toggle="tooltip" data-placement="bottom" title="点击自动复制" placeholder="验证码">
                                </div>
                                <div class="col-sm-6">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" id="AutoRlease" checked="checked">
                                            获取短信后自动释放号码
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-3">
                                </div>
                                <div class="col-sm-9">
                                    <div class="btn-group">
                                        <button type="button" id="GetSMSBtn" class="btn btn-sm btn-success">获取短信</button>
                                        <button type="button" id="ShowSendSMSBtn" class="btn btn-sm btn-warning" title="使用获取的手机号码将指定内容发送到项目设置的接收号码">发送短信</button>
                                        <button type="button" class="btn btn-sm btn-primary" id="AssignMobileNoBtn" title="只能指定本平台内的号码">获取指定手机号</button>
                                        <button type="button" id="ReleaseAllMobileNoBtn" class="btn btn-sm btn-danger" title="释放你的账号获取过的所有号码">释放全部</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="box-footer">
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>

@endsection

@section('script')
    <script>
        $("#brandsignselect").change(function() {
            if ($('#brandsignselect').val()) {

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
                $("<option value=''>--暂未开放--</option>").appendTo($("#ispsignselect"))

            }
        });

    </script>
@endsection


