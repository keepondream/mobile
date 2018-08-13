<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMobileLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mobile_logs', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id')->index()->default('0')->commit('用户ID');
            $table->string('brand_name')->default('')->commit('获取手机号使用的平台');
            $table->string('order_id')->default('')->index()->commit('获取手机号时的订单ID');
            $table->unsignedInteger('num')->default('0')->commit('当前订单批次获取手机号的总数量');
            $table->string('mobile')->default('')->commit('获取的手机号码');
            $table->tinyInteger('mobile_status')->default('0')->commit('是否获取手机 0 未获取 1 已获取 2 获取失败');
            $table->integer('mobile_repetition')->default('0')->commit('手机号重复获取次数');
            $table->unsignedInteger('get_mobile_time')->default('0')->commit('获取手机号的时间->时间戳');
            $table->string('sms_content')->default('')->commit('短信内容');
            $table->tinyInteger('is_sms')->default('0')->commit('是否获取短信 0 未获取 1 已获取 2 获取失败');
            $table->integer('sms_repetition')->default('0')->commit('短信重复获取次数');
            $table->unsignedInteger('get_sms_time')->default('0')->commit('获取短信的时间->时间戳');
            $table->tinyInteger('is_send')->default('0')->commit('是否发送短信 0 未发送 1 已发送 ');
            $table->integer('send_status_repetition')->default('0')->commit('获取发送短信结果重复获取次数');
            $table->tinyInteger('send_status')->default('0')->commit('是否发送成功 0 未成功 1 已成功 2 发送失败');
            $table->tinyInteger('is_block')->default('0')->commit('是否拉黑 0 未拉黑 1 已拉黑 ->之后将不再获取此手机号');
            $table->tinyInteger('is_release')->default('0')->commit('是否释放 0 未释放 1 已释放');
            $table->tinyInteger('is_credit_return')->default('0')->commit('是否返回积分 0 未返回 1 已返回');
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
        Schema::dropIfExists('mobile_logs');
    }
}
