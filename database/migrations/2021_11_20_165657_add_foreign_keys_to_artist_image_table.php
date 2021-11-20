<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToArtistImageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('artist_image', function (Blueprint $table) {
            $table->foreign('image_id')->references('id')->on('images');
            $table->foreign('artist_id')->references('id')->on('artists');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('artist_image', function (Blueprint $table) {
            $table->dropForeign(['image_id']);
            $table->dropForeign(['artist_id']);
        });
    }
}
