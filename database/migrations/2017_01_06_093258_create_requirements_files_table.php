<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRequirementsFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('requirements_files', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('requirement_id')->comment('需求ID');
            $table->string('path')->unique()->comment('文件路径');
            $table->string('name')->index()->comment('文件名');
            $table->string('local_path')->comment('本地路径');
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
        Schema::dropIfExists('requirements_files');
    }
}
