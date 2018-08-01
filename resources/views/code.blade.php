@extends('layouts.app')

@section('content')
    <div class="container ui-sortable">
        <div class="row cl">
            <div class="col-xl-12 col-sm-6 mt-20">
                <label for=""></label>
                <h3 class="label label-success radius ">
                    基础信息
                </h3>
                <div class="text-l">左对齐</div>
                <div class="text-c">居中对齐</div>
                <div class="text-r">右对齐</div>
                当前用户{{$user->name}}
            </div>
        </div>
        <div class="row cl">

        </div>
        <div class="row cl">
            <div class="col-md-12">
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
        </div>

    </div>

@endsection


