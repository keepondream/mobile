<?php

namespace App\http\Model;

use Illuminate\Database\Eloquent\Model;

class MobileLog extends Model
{
    /**
     * 与模型关联的数据表
     *
     * @var string
     */
    protected $table = 'mobile_logs';

    /**
     * 可以被批量赋值的属性。
     *
     * @var array
     */
    protected $fillable = ['user_id','order_id','brand_type','itemid','num','mobile','mobile_status','mobile_repetition','get_mobile_time','sms_content','is_sms','sms_repetition','get_sms_time','is_send','send_status_repetition','send_status','is_block','is_release','is_credit_return'];

}


