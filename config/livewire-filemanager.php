<?php
return [
    /*
    |--------------------------------------------------------------------------
    | ACL Feature
    |--------------------------------------------------------------------------
    |
    | If set to true, file access will be restricted to the users who created the files.
    |
    */
    'acl_enabled' => false,

    /*
    |--------------------------------------------------------------------------
    | API Configuration
    |--------------------------------------------------------------------------
    |
    | Configure the API endpoints for file management operations.
    |
    */
    'api' => [
        'enabled' => true,
        'prefix' => 'filemanager/v1',
        'middleware' => ['api'],
        'rate_limit' => '100,1',
        'max_file_size' => 102400,
        'allowed_extensions' => ['jpg', 'jpeg', 'png', 'gif', 'pdf', 'doc', 'docx', 'txt', 'zip'],
        'chunk_size' => 2097152,
    ],

    /*
    |--------------------------------------------------------------------------
    | Folder Configuration
    |--------------------------------------------------------------------------
    |
    | Configure folder creation and management settings.
    |
    */
    'folders' => [
        'max_depth' => 'fm/f',
    ],

    /*
    |--------------------------------------------------------------------------
    | Callbacks
    |--------------------------------------------------------------------------
    |
    | Custom callbacks for extending functionality.
    |
    */
    'callbacks' => [
        'before_upload' => [\App\Services\FilemanagerCallback::class, 'beforeUpload'],
        'after_upload' => [\App\Services\FilemanagerCallback::class, 'afterUpload'],
        'access_check' => [\App\Services\FilemanagerCallback::class, 'accessCheck'],
    ],
];
