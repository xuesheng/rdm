<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRequirementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('requirements', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('serial_number')->unique()->comment('需求编号');
            $table->unsignedInteger('user_id')->comment('用户ID');
            $table->string('name')->comment('需求名称');
            $table->string('sponsor', 20)->comment('需求发起者');
            $table->string('remark')->default('')->comment('备注');
            $table->string('directory_name')->default('')->comment('需求对应目录名');
            $table->unsignedInteger('finished_at')->default(0)->comment('截止时间');
            $table->unsignedInteger('deployment_at')->default(0)->comment('上线时间');
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
        Schema::dropIfExists('requirements');
    }
}
