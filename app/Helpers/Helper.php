<?php

namespace App\Helpers;

use Illuminate\Support\Str;

class Helper
{
    /**
     * Make a filename URL-safe and prepend timestamp.
     */
    public static function makeSafeFilename($originalName)
    {
        // Remove extension
        $nameWithoutExt = pathinfo($originalName, PATHINFO_FILENAME);
        $extension = pathinfo($originalName, PATHINFO_EXTENSION);

        // Slugify the name
        $safeName = Str::slug($nameWithoutExt, '-');

        // Limit length for safety (100 chars)
        $safeName = Str::limit($safeName, 100, '');

        // Return final safe name
        return time() . '_' . $safeName . '.' . strtolower($extension);
    }
}
