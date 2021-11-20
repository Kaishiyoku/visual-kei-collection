<?php

use App\Models\Artist;
use Carbon\Carbon;
use Illuminate\Support\Collection;

if (!function_exists('formatFileSize')) {
    function formatFileSize(int $fileSize): string
    {
        return ByteFormatter::format($fileSize);
    }
}

if (!function_exists('formatDateTime')) {
    function formatDateTime(?Carbon $date): string
    {
        return optional($date, fn(Carbon $date) => $date->format(__('date.datetime')));
    }
}

if (!function_exists('getArtistNamesForTagInput')) {
    function getArtistNamesForTagInput(): Collection
    {
        return Artist::query()
            ->select(['name'])
            ->orderBy('name')
            ->get()
            ->pluck('name')
            ->map(fn (string $artistName) => [
                'label' => $artistName,
                'description' => null,
            ]);
    }
}
