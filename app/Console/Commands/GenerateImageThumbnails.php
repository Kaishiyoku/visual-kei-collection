<?php

namespace App\Console\Commands;

use App\Http\Controllers\ImageController;
use App\Models\Image;
use Illuminate\Console\Command;
use Storage;

class GenerateImageThumbnails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'images:thumbnails';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate image thumbnails';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $images = Image::orderBy('id');

        // clean up directory first
        Storage::disk('vk')->deleteDir('thumbnails');

        $images->each(fn(Image $image) => ImageController::saveThumbnail($image));

        return Command::SUCCESS;
    }
}
