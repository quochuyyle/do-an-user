<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('push_notification', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 191)->nullable()->default(null);
            $table->text('content')->nullable()->default(null);
//            $table->integer('user_id')->unsigned()->nullable()->default(null);
            $table->integer('sender_id')->unsigned()->nullable()->default(null);
//            $table->text('data')->nullable()->default(null);
            $table->integer('status')->unsigned()->nullable()->default(null);
//            $table->integer('reference_id')->unsigned()->nullable()->default(null);
            $table->integer('type')->unsigned()->nullable()->default(null);
            $table->integer('source')->nullable()->default(null)->comment('local send: 1-admin, 2-teacher/school, 3-parent/student');
            $table->integer('source_to')->nullable()->default(null)->comment('local receive: 1-admin, 2-teacher/school, 3-parent/student');
            $table->text('json_push')->nullable()->default(null);
//            $table->string('screen', 191)->nullable()->default(null);
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
//        Schema::dropIfExists('notifications');
    }
}
