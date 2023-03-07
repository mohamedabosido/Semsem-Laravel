<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id();
            $table->string('uid');
            $table->unsignedBigInteger('pid');
            $table->integer('count');
            $table->timestamps();
        });

        Schema::table('orders', function (Blueprint $table) {
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
        Schema::dropIfExists('orders');
    }
}
