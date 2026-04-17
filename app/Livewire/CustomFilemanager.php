<?php

namespace App\Livewire;

use LivewireFilemanager\Filemanager\Livewire\LivewireFilemanagerComponent;
use LivewireFilemanager\Filemanager\Models\Folder;

class CustomFilemanager extends LivewireFilemanagerComponent
{
    /**
     * Override mount to fix root folder bug when session is empty.
     */
    public function mount()
    {
        if (! session('currentFolderId')) {
            // FIX: Look for a root folder (parent_id is NULL) instead of a subfolder
            $rootFolder = Folder::whereNull('parent_id')->first();
            session(['currentFolderId' => $rootFolder ? $rootFolder->id : null]);
        }

        $currentFolderId = session('currentFolderId');

        $this->currentFolder = Folder::with(['children', 'parent'])->where('id', $currentFolderId)->first();
        $this->breadcrumb = $this->generateBreadcrumb($this->currentFolder);

        if ($this->currentFolder) {
            $this->loadFolders();
        }
    }

    /**
     * Re-implement generateBreadcrumb as it is private in parent
     */
    private function generateBreadcrumb($folder)
    {
        $breadcrumb = [];

        while ($folder) {
            array_unshift($breadcrumb, $folder);

            $folder = $folder->parent;
        }

        return $breadcrumb;
    }
}
