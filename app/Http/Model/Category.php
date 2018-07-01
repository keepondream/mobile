<?php

namespace App\http\Model;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    //categories
    /**
     * 与模型关联的数据表
     *
     * @var string
     */
    protected $table = 'categories';

    /**
     * 可以被批量赋值的属性。
     *
     * @var array
     */
    protected $fillable = ['name','parent_id','sort','desc','status'];

}
