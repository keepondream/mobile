<?php

namespace App\http\Model;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    //
    /**
     * 与模型关联的数据表
     *
     * @var string
     */
    protected $table = 'brands';

    /**
     * 可以被批量赋值的属性。
     *
     * @var array
     */
    protected $fillable = ['name','desc','category_id','sort','status'];

    /**
     * 获得此平台的项目。
     */
    public function projects()
    {
        return $this->hasMany('App\http\Model\Project','id','brand_id');
    }

}
