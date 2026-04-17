<?php

namespace App\Observers;

use Illuminate\Support\Facades\Storage;
use LivewireFilemanager\Filemanager\Models\Media;

class MediaObserver
{
    /**
     * Handle the Media "deleted" event.
     * Delete the physical file and folder when media record is deleted.
     */
    public function deleted(Media $media): void
    {
        $disk = Storage::disk('filemanager');
        $mediaId = $media->getKey();

        // Try multiple path patterns for backward compatibility
        $paths = [
            'fm/'.$mediaId.'/'.$media->file_name,
            $mediaId.'/'.$media->file_name,
        ];

        $fileDeleted = false;
        foreach ($paths as $path) {
            if ($disk->exists($path)) {
                $disk->delete($path);
                $fileDeleted = true;
                break;
            }
        }

        // Delete the media_id folder if empty
        if ($fileDeleted) {
            $folderPaths = [
                'fm/'.$mediaId,
                $mediaId,
            ];

            foreach ($folderPaths as $folderPath) {
                if ($disk->exists($folderPath) && empty($disk->files($folderPath))) {
                    $disk->deleteDirectory($folderPath);
                    break;
                }
            }
        }
    }
}
