<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTablePushUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('push_user', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('push_id')->nullable()->default(0);
            $table->integer('user_id')->nullable()->default(0);
            $table->integer('read')->nullable()->default(0);
            $table->integer('user_type')->nullable()->comment('local receive: 1-admin, 2-teacher/school, 3-parent/student');
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
        //
    }
}
