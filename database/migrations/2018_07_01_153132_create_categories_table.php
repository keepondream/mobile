<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->commit('分类名称');
            $table->unsignedInteger('parent_id')->default('0')->index()->commit('上级分类');
            $table->string('sort')->default('50')->commit('排序');
            $table->string('url')->default('')->commit('分类地址');
            $table->tinyInteger('status')->default('1')->commit('状态 0 停用 1 启用');
            $table->string('desc')->default('')->commit('描述');
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
        Schema::dropIfExists('categories');
    }
}
