<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id();
            $table->string('type');
            $table->string('uid');
            $table->unsignedBigInteger('pid');
            $table->boolean('isRead');
            $table->timestamps();
        });
        Schema::table('notifications', function (Blueprint $table) {
            $table->foreign('uid')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('pid')->references('id')->on('products')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notifications');
    }
}
