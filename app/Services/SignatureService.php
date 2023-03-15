<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;

class SignatureService
{
    /**
     * Resolve the path to the given filename.
     */
    private static function filename(string $name): string
    {
        return 'public/signatures/' . $name . '.svg';
    }

    /**
     * Store data to the filesystem.
     */
    public static function put(string $name, string $blob)
    {
        // get the raw data from the svg blob
        $rawData = explode('data:image/svg+xml;base64,', $blob)[1];

        // decode the raw data
        $decodedData = base64_decode($rawData);

        Storage::put(self::filename($name), $decodedData);
    }

    /**
     * Get URL to the given signature.
     */
    public static function url(string $name): string
    {
        return Storage::url(self::filename($name));
    }
}
