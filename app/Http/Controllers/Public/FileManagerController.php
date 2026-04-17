<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;
use LivewireFilemanager\Filemanager\Http\Controllers\Files\FileController;
use LivewireFilemanager\Filemanager\Models\Media;

class FileManagerController extends Controller
{
    /**
     * Show file by path.
     */
    public function show(string $path)
    {
        return app(FileController::class)->show($path);
    }

    /**
     * Get public file URL by ID.
     */
    public function getPublicFile(string $id): JsonResponse
    {
        $media = Media::find($id);

        if (! $media) {
            return response()->json(['message' => 'Media not found'], 404);
        }

        // Return UUID-based path: /storage/fm/{uuid}/filename
        $path = '/storage/fm/'.$media->uuid.'/'.$media->file_name;
        $url = config('app.url').$path;

        return response()->json([
            'id' => $media->id,
            'uuid' => $media->uuid,
            'url' => $url,
            'path' => $path,
            'name' => $media->name,
            'file_name' => $media->file_name,
            'mime_type' => $media->mime_type,
        ]);
    }

    /**
     * Serve file by UUID (maps to media_id for backward compatibility).
     * View in browser if viewable (images, pdf, video, audio), download otherwise.
     */
    public function storageByUuid(string $uuid, string $filename)
    {
        $media = Media::where('uuid', $uuid)->first();

        if (! $media) {
            abort(404);
        }

        // Check new UUID-based path first, fallback to legacy media_id path
        $newPath = 'fm/' . $media->getKey() . '/' . $filename;
        $legacyPath = $media->getKey() . '/' . $filename;

        $disk = Storage::disk('filemanager');

        // Try new UUID path first, then legacy path
        if ($disk->exists($newPath)) {
            $path = $newPath;
        } else {
            $path = $legacyPath;
        }

        // Check if file is viewable in browser
        if ($this->isViewableMimeType($media->mime_type)) {
            return $disk->response($path);
        }

        return $disk->download($path);
    }

    /**
     * Determine if MIME type can be viewed in browser.
     */
    private function isViewableMimeType(?string $mimeType): bool
    {
        if (! $mimeType) {
            return false;
        }

        $viewableTypes = [
            // Images
            'image/jpeg',
            'image/png',
            'image/gif',
            'image/webp',
            'image/svg+xml',
            'image/bmp',
            // PDF
            'application/pdf',
            // Video
            'video/mp4',
            'video/webm',
            'video/ogg',
            // Audio
            'audio/mpeg',
            'audio/wav',
            'audio/ogg',
        ];

        return in_array($mimeType, $viewableTypes);
    }
}
