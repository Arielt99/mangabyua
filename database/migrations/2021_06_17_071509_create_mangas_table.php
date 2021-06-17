<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMangasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mangas', function (Blueprint $table) {
            $table->id();
            $table->text('title');
            $table->string('slug');
            $table->longText('description');
            $table->boolean('isMature')->default(false);
            $table->timestamps();
            $table->softDeletes();
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
            $table->dropForeign('manga_id');
            $table->dropSoftDeletes();
        });
        Schema::dropIfExists('mangas');
    }
}
