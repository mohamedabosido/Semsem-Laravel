<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFavoritesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('favorites', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->string('uid');
            $table->unsignedBigInteger('pid');
            $table->timestamps();
        });

        Schema::table('favorites', function (Blueprint $table) {
            $table->foreign('uid')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('pid')->references('id')->on('products')->onDelete('cascade');
            $table->primary(['uid', 'pid']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('favorites');
    }
}
