<?php

namespace App\http\Model;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    /**
     * 与模型关联的数据表
     *
     * @var string
     */
    protected $table = 'roles';

    /**
     * 可以被批量赋值的属性。
     *
     * @var array
     */
    protected $fillable = ['name','desc'];

    /**
     * 获取角色对应的用户。
     * 一个角色可以被多个用户拥有 即为 一对多关系
     */
    public function hasManyAdminUsers()
    {
        //第一参数 命名空间  第二参数被关联数据表中的字段名(外键) 第三参数 是此模型中对应被关联模型的字段名(內键)
        return $this->hasMany('App\http\Model\AdminUser','role_id','id');
    }

    /**
     * 获取角色对应的权限。
     * 一个角色可以有多个权限 即为 一对多关系
     */
    public function hasManyAccesses()
    {
        //第一参数 命名空间  第二参数被关联数据表中的字段名(外键) 第三参数 是此模型中对应被关联模型的字段名(內键)
        return $this->hasMany('App\http\Model\RoleAccess','role_id','id');
    }
}
