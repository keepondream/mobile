<?php

namespace App\http\Model;

use Illuminate\Database\Eloquent\Model;

class RoleAccess extends Model
{
    //
    /**
     * 与模型关联的数据表
     *
     * @var string
     */
    protected $table = 'role_accesses';

    /**
     * 可以被批量赋值的属性。
     *
     * @var array
     */
    protected $fillable = ['role_id','access_id'];

    /**
     * 有问题待重新搞
     * 获取权限拥有的角色
     */
    public function belongsToRoles()
    {
        //第一参数 命名空间  第二参数 被关联的数据表名 第三个参数是定义此关联的模型在连接表里的键名，第四个参数是另一个模型在连接表里的键名：
        return $this->belongsToMany('App\http\Model\Role','roles','access_id','role_id');
    }

    /**
     * 获取权限对应的权限操作信息
     */
    public function hasOneAction()
    {
        return $this->hasOne('App\http\Model\Access','id','access_id');
    }
}
