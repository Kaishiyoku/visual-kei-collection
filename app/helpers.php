<?php

use Carbon\Carbon;

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
