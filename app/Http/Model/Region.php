<?php

namespace App\http\Model;

use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    /**
     * 与模型关联的数据表
     *
     * @var string
     */
    protected $table = 'regions';

    /**
     * 可以被批量赋值的属性。
     *
     * @var array
     */
    protected $fillable = ['code','name','parent_id'];
}
