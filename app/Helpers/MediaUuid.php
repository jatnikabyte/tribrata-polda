<?php

use LivewireFilemanager\Filemanager\Models\Media;

if (! function_exists('getMediaUuidUrl')) {
    /**
     * Get the full UUID-based URL with domain.
     * Returns URL in format: http://domain.com/storage/fm/{uuid}/{filename}
     */
    function getMediaUuidUrl(Media $media): string
    {
        return rtrim(config('app.url'), '/') . '/storage/fm/' . $media->uuid . '/' . $media->file_name;
    }
}

if (! function_exists('getMediaUuidPath')) {
    /**
     * Get the UUID-based path for a media file.
     * Returns path in format: storage/fm/{uuid}/{filename}
     */
    function getMediaUuidPath(Media $media): string
    {
        return 'fm/'.$media->uuid.'/'.$media->file_name;
    }
}
