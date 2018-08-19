<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class Site extends Model
{
    /**
     * 与模型关联的数据表
     *
     * @var string
     */
    protected $table = 'sites';

    /**
     * 可以被批量赋值的属性。
     *
     * @var array
     */
    protected $fillable = ['title','keywords','description','icp','countscript','copyright','keywords1','keywords2','keywords3'];

}
