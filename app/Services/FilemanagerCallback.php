<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;

class FilemanagerCallback
{
    /**
     * Callback to set custom upload path before file upload
     */
    public static function beforeUpload($file, $folder)
    {
        // Custom upload path: fm/{hash_user_id}
        if (Auth::check()) {
            $userId = Auth::id();
            $hash = md5($userId);

            return [
                'disk' => 'filemanager',
                'path_prefix' => $hash,
            ];
        }

        return [
            'disk' => 'filemanager',
            'path_prefix' => '',
        ];
    }

    /**
     * Callback after file upload
     */
    public static function afterUpload($media, $file)
    {
        // Perform actions after file upload
        // For example: create thumbnails, send notifications, etc.

        return $media;
    }

    /**
     * Callback to check file access
     */
    public static function accessCheck($media)
    {
        // Implement custom access control logic
        // Return true if user can access to file, false otherwise

        if (Auth::check()) {
            // Example: Only allow access to user's own files
            return $media->custom_properties['user_id'] == Auth::id();
        }

        return false;
    }
}
