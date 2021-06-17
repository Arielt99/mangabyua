<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MangakaManga extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mangaka_manga', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('mangaka_id');
            $table->foreign('mangaka_id')->references('id')->on('users')->onDelete('cascade');

            $table->unsignedBigInteger('manga_id');
            $table->foreign('manga_id')->references('id')->on('mangas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tag_manga', function(Blueprint $table) {
            $table->dropForeign('mangaka_id');
            $table->dropForeign('manga_id');
        });
        Schema::dropIfExists('mangaka_manga');
    }
}
