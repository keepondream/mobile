<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique()->commit('用户名');
            $table->string('email')->default('')->commit('邮箱');
            $table->string('password')->commit('密码');
            $table->tinyInteger('sex')->default('2')->commit('性别: 默认为女  1: 男 3: 保密');
            $table->string('mobile')->default('')->commit('手机号');
            $table->string('datetimepicker')->default('')->commit('出生日期');
            $table->string('area')->default('')->commit('省份区域');
            $table->string('city')->default('')->commit('城市');
            $table->string('desc')->default('')->commit('个人描述');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
