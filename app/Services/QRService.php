<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class QRService
{
    /**
     * Resolve the path to the given filename.
     */
    private static function filename(string $name): string
    {
        return 'public/qr/' . $name . '.svg';
    }

    /**
     * Ensure that a QR code exists for given filename or create it.
     */
    private static function ensureExists(string $filename, string $data): void
    {
        if (Storage::missing($filename)) {
            Storage::put($filename, QrCode::generate($data));
        }
    }

    /**
     * Get url to QR code for given name and data.
     */
    public static function urlFor(string $name, string $data): string
    {
        $filename = self::filename($name);

        self::ensureExists($filename, $data);

        return Storage::url($filename);
    }
}
