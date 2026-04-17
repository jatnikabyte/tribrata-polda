<?php

namespace App\Services\Filemanager;

use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\Support\PathGenerator\PathGenerator;

class UserHashPathGenerator implements PathGenerator
{
    public function getPath(Media $media): string
    {
        // Use UUID from media table for unique folder per file
        $uuid = $media->uuid;

        if ($uuid) {
            return 'fm/' . $uuid . '/';
        }

        return 'fm/guest/';
    }

    public function getPathForConversions(Media $media): string
    {
        return $this->getPath($media).'conversions/';
    }

    public function getPathForResponsiveImages(Media $media): string
    {
        return $this->getPath($media).'responsive/';
    }
}
