<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('images', function (Blueprint $table) {
            $table->id();
            $table->binary('identifier_image')->nullable();
            $table->string('identifier', 8000)->nullable();
            $table->string('source')->nullable();
            $table->string('mimetype');
            $table->string('file_extension');
            $table->unsignedBigInteger('file_size');
            $table->unsignedBigInteger('width');
            $table->unsignedBigInteger('height');
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
        Schema::dropIfExists('images');
    }
}
