<?php

namespace App\http\Model;

use Illuminate\Database\Eloquent\Model;

class AdminUser extends Model
{
    /**
     * 与模型关联的数据表
     *
     * @var string
     */
    protected $table = 'admin_users';


    protected $fillable = ['name','password','role_id','password','sex','mobile','email'];

    /**
     * 此方法有问题 没关联好
     * 获得此用户的角色。
     */
    public function roles()
    {
        //第一参数 命名空间  第二参数 被关联的数据表名 第三个参数是定义此关联的模型在连接表里的键名，第四个参数是另一个模型在连接表里的键名：
        return $this->belongsToMany('App\http\Model\Role','roles','admin_user_id','role_id');
    }
    /**
     * 获得与用户关联的角色信息。
     */
    public function hasOneRoles()
    {
        // 1:关联模型 命名空间   2: 外键(被关联表中的键)  3: 主键(本表中的哪个字段名与被关联表中对应)
        return $this->hasOne('App\http\Model\Role','id','role_id');
    }
}
