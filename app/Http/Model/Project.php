<?php

namespace App\http\Model;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    /**
     * 与模型关联的数据表
     *
     * @var string
     */
    protected $table = 'projects';

    /**
     * 可以被批量赋值的属性。
     *
     * @var array
     */
    protected $fillable = ['name','sign','desc','brand_id','sort','status'];
}
