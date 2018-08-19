<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSitesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sites', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->default('')->commit('网站标题');
            $table->string('keywords')->default('')->commit('关键字');
            $table->string('description')->default('')->commit('网站描述');
            $table->string('keywords1')->default('')->commit('顶部导航宣传语1');
            $table->string('keywords2')->default('')->commit('顶部导航宣传语2');
            $table->string('keywords3')->default('')->commit('顶部导航宣传语3');
            $table->string('copyright')->default('')->commit('版权');
            $table->string('icp')->default('')->commit('备案号');
            $table->string('countscript',500)->default('')->commit('统计代码');
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
        Schema::dropIfExists('sites');
    }
}
