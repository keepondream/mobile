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

    /**
     * 获得此项目所属的平台。
     */
    public function brand()
    {
        # 与外部平台表关联的字段(brand_id)  如果需要用别的字段 则可以给第三参数  指定其他字段关联
        return $this->belongsTo('App\http\Model\Brand','brand_id');
    }

}
