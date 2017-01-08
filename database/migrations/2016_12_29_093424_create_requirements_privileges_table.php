<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRequirementsPrivilegesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('requirements_privileges', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('requirement_id')->comment('需求ID');
            $table->string('privilege')->comment('权限名');
            $table->string('privilege_alias')->comment('权限别名');
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
        Schema::dropIfExists('requirements_privileges');
    }
}
