<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->default('')->commit('项目名称');
            $table->string('sign')->default('')->commit('项目编号');
            $table->string('desc')->default('')->commit('项目描述');
            $table->unsignedInteger('sort')->index()->default('50')->commit('项目排序');
            $table->unsignedInteger('brand_id')->index()->default('50')->commit('项目所属平台ID');
            $table->tinyInteger('status')->default('1')->commit('状态 0停用 1启用');
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
        Schema::dropIfExists('projects');
    }
}
