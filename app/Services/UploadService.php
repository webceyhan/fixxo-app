<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

class UploadService
{
    const DIRECTORY = 'public/uploads/';

    /**
     * Store all files under a given subfolder.
     * 
     * @param UploadedFile[] $files
     * @param string $subFolder
     */
    public static function putAll(array $files, string $subFolder): void
    {
        $rootPath = self::DIRECTORY . $subFolder;

        // store files to the filesystem
        foreach ($files as $file) {
            $path = $file->store($rootPath);
        }
    }

    /**
     * Get url of all files under a given subfolder.
     */
    public static function urls(string $subFolder): string
    {
        $rootPath = self::DIRECTORY . $subFolder;

        $files = Storage::allFiles($rootPath);

        return collect($files)->map(fn ($path) => Storage::url($path));
    }
}
