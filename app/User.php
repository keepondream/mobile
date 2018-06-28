<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','sex','mobile','datetimepicker','area','city','desc','avatar','county'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * 获取省
     */
    public function hasOneArea()
    {
        return $this->hasOne('App\http\Model\Region','code','area');
    }
    /**
     * 获取市
     */
    public function hasOneCity()
    {
        return $this->hasOne('App\http\Model\Region','code','city');
    }
    /**
     * 获取区县
     */
    public function hasOneCounty()
    {
        return $this->hasOne('App\http\Model\Region','code','county');
    }
}
