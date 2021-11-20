<?php

use App\Console\Commands\GenerateImageThumbnails;
use Illuminate\Database\Migrations\Migration;

class GenerateThumbnails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Artisan::call(GenerateImageThumbnails::class);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
