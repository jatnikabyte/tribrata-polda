<?php

namespace App\Providers;

use App\Observers\MediaObserver;
use Illuminate\Support\ServiceProvider;
use LivewireFilemanager\Filemanager\Models\Folder;
use LivewireFilemanager\Filemanager\Models\Media as FilemanagerMedia;
use Livewire\Livewire;
use App\Livewire\CustomFilemanager;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Override Livewire Filemanager Component
        Livewire::component('livewire-filemanager', CustomFilemanager::class);


        // Register Media observer to delete physical files
        FilemanagerMedia::observe(MediaObserver::class);

        // Configure filemanager to use custom disk
        Folder::retrieved(function ($folder) {
            $folder->disk = 'filemanager';
        });

        Folder::creating(function ($folder) {
            $folder->disk = 'filemanager';
        });

        // Configure media model to use custom disk
        FilemanagerMedia::retrieved(function ($media) {
            $media->disk = 'filemanager';
        });

        FilemanagerMedia::creating(function ($media) {
            $media->disk = 'filemanager';
        });
    }
}
