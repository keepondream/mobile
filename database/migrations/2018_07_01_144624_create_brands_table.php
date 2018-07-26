<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBrandsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('brands', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->commit('平台名称');
            $table->string('desc')->default('')->commit('平台描述');
            $table->unsignedInteger('category_id')->index()->default('0')->commit('分类ID');
            $table->unsignedInteger('sort')->index()->default('50')->commit('排序');
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
        Schema::dropIfExists('brands');
    }
}
