<?php

namespace App\http\Model;

use Illuminate\Database\Eloquent\Model;

class AdminUserLog extends Model
{
    /**
     * 与模型关联的数据表
     *
     * @var string
     */
    protected $table = 'admin_user_logs';

    /**
     * 可以被批量赋值的属性。
     *
     * @var array
     */
    protected $fillable = ['admin_user_id','admin_user_name','action','actiondesc','admin_user_agent_type','admin_user_agent_name','admin_user_agent_str','ip','mobile'];
}
