<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsToMotelroomTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('motelrooms', function (Blueprint $table) {
            $table->integer('status')->default(0);
            $table->integer('post_type')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('motelrooms', function (Blueprint $table) {
            $table->removeColumn('status');
            $table->removeColumn('post_type');
        });
    }
}
