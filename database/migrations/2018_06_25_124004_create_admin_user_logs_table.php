<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminUserLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_user_logs', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('admin_user_id')->index()->commit('管理员用户ID');
            $table->string('admin_user_name')->default('')->commit('管理员名称');
            $table->string('action')->default('')->commit('动作项类型');
            $table->string('actiondesc')->default('')->commit('操作描述');
            $table->string('admin_user_agent_type')->default('')->commit('访问端说明 : pc  ios 安卓');
            $table->string('admin_user_agent_name')->default('')->commit('登录设备');
            $table->string('admin_user_agent_str')->default('')->commit('登录设备详情');
            $table->string('ip')->default('')->commit('登录时IP');
            $table->string('mobile')->default('')->commit('手机登录抓取的手机号');
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
        Schema::dropIfExists('admin_user_logs');
    }
}
