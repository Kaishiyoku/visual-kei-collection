<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePossibleDuplicatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('possible_duplicates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('image_id_left');
            $table->foreignId('image_id_right');
            $table->boolean('is_false_positive')->default(false);
            $table->timestamps();

            $table->foreign('image_id_left')->references('id')->on('images');
            $table->foreign('image_id_right')->references('id')->on('images');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('possible_duplicates');
    }
}
