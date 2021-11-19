<?php

use App\Enums\ImageRating;
use App\Models\Image;
use App\Models\PossibleDuplicate;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use ImgFing\ImgFing;
use Intervention\Image\Exception\NotReadableException;
use Intervention\Image\ImageManager;
use ScriptFUSION\Byte\ByteFormatter;

if (!function_exists('getImageFromStorage')) {
    function getImageFromStorage(Image $image): ?\Intervention\Image\Image
    {
        if (!$image->mimetype) {
            return null;
        }

        try {
            return getImageManager()->make(Storage::disk('vk')->path($image->getFileName()));
        } catch (NotReadableException $e) {
            return null;
        }
    }
}

if (!function_exists('getImageDataFromStorage')) {
    function getImageDataFromStorage(Image $image): ?string
    {
        return optional(getImageFromStorage($image), function ($data) {
            return $data->psrResponse()->getBody()->getContents();
        });
    }
}

if (!function_exists('getImageFileMimetype')) {
    function getImageFileMimetype(Image $image)
    {
        if (Storage::disk('local')->exists($image->getFilePath())) {
            return Storage::disk('local')->mimeType($image->getFilePath());
        }

        return null;
    }
}

if (!function_exists('formatFileSize')) {
    function formatFileSize(int $fileSize): string
    {
        return byteFormatter()->format($fileSize);
    }
}

if (!function_exists('deleteImage')) {
    function deleteImage(Image $image): void
    {

    }
}

if (!function_exists('formatDateTime')) {
    function formatDateTime(?Carbon $date): string
    {
        return optional($date, fn(Carbon $date) => $date->format(__('date.datetime')));
    }
}

if (!function_exists('getImageManager')) {
    /**
     * @return ImageManager
     */
    function getImageManager(): ImageManager
    {
        return new ImageManager();
    }
}

if (!function_exists('imgFing')) {
    function imgFing(): ImgFing
    {
        return new ImgFing([
            'bitSize' => 3000,
            'avgColorAdjust' => 50,
            'cropFit' => false,
            'adapters' => [
                'GD',
            ],
        ]);
    }
}

if (!function_exists('byteFormatter')) {
    function byteFormatter(): ByteFormatter
    {
        return new ByteFormatter();
    }
}
