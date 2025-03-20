<?php

namespace Modules\Base\Helpers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

class GalleryHelper
{
    /**
     * Save an uploaded file (image, video, icon) to the specified disk and folder.
     *
     * @param UploadedFile|null $file The uploaded file instance.
     * @param string $folder The folder where the file will be saved (e.g., 'images', 'videos').
     * @param string $disk The storage disk to use (e.g., 'public', 's3').
     * @return string|null The file path of the saved file or null if no file was uploaded.
     */
    public static function saveAsset(?UploadedFile $file, string $folder, string $disk = 'public'): ?string
    {
        if (!$file) {
            return null; // No file uploaded
        }

        // Generate a unique filename
        $filename = uniqid() . '.' . $file->getClientOriginalExtension();

        // Save the file to the specified disk and folder
        $path = $file->storeAs($folder, $filename, $disk);

        // Return the file path
        return $path;
    }

    /**
     * Delete an existing asset from storage.
     *
     * @param string|null $path The file path to delete.
     * @param string $disk The storage disk to use (e.g., 'public', 's3').
     * @return bool True if the file was deleted, false otherwise.
     */
    public static function deleteAsset(?string $path, string $disk = 'public'): bool
    {
        if (!$path) {
            return false; // No file to delete
        }

        return Storage::disk($disk)->exists($path) && Storage::disk($disk)->delete($path);
    }
}