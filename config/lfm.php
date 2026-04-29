<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Routing
    |--------------------------------------------------------------------------
    */
    'use_package_routes' => true,

    /*
    |--------------------------------------------------------------------------
    | Shared folder / Private folder
    |--------------------------------------------------------------------------
    */
    'allow_private_folder' => true,
    'private_folder_name' => UniSharp\LaravelFilemanager\Handlers\ConfigHandler::class,
    'allow_shared_folder' => false,
    'shared_folder_name' => 'shares',

    /*
    |--------------------------------------------------------------------------
    | Folder Categories
    |--------------------------------------------------------------------------
    */
    'folder_categories' => [
        'file' => [
            'folder_name' => 'files',
            'startup_view' => 'grid',
            'max_size' => 50000, // in KB
            'valid_mime' => [
                'image/jpeg',
                'image/pjpeg',
                'image/png',
                'image/gif',
                'image/svg+xml',
                'application/pdf',
                'text/plain',
            ],
        ],
        'image' => [
            'folder_name' => 'uploads/images', // <- updated folder path
            'startup_view' => 'list',
            'max_size' => 50000, // in KB
            'valid_mime' => [
                'image/jpeg',
                'image/pjpeg',
                'image/png',
                'image/gif',
                'image/svg+xml',
                'application/pdf',
                'text/plain',
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Pagination
    |--------------------------------------------------------------------------
    */
    'paginator' => [
        'perPage' => 30,
    ],

    /*
    |--------------------------------------------------------------------------
    | Upload / Validation
    |--------------------------------------------------------------------------
    */
    'disk' => 'public', // <- default storage disk, can be changed to s3 or others
    'rename_file' => false,
    'alphanumeric_filename' => false,
    'alphanumeric_directory' => false,
    'should_validate_size' => true, // <- enable size validation
    'should_validate_mime' => true, // <- enable mime validation
    'over_write_on_duplicate' => false,

    /*
    |--------------------------------------------------------------------------
    | Thumbnails
    |--------------------------------------------------------------------------
    */
    'should_create_thumbnails' => true,
    'thumb_folder_name' => 'thumbs',
    'raster_mimetypes' => [
        'image/jpeg',
        'image/pjpeg',
        'image/png',
    ],
    'thumb_img_width' => 200,
    'thumb_img_height' => 200,

    /*
    |--------------------------------------------------------------------------
    | File Extension Information
    |--------------------------------------------------------------------------
    */
    'file_type_array' => [
        'pdf' => 'Adobe Acrobat',
        'doc' => 'Microsoft Word',
        'docx' => 'Microsoft Word',
        'xls' => 'Microsoft Excel',
        'xlsx' => 'Microsoft Excel',
        'zip' => 'Archive',
        'gif' => 'GIF Image',
        'jpg' => 'JPEG Image',
        'jpeg' => 'JPEG Image',
        'png' => 'PNG Image',
        'ppt' => 'Microsoft PowerPoint',
        'pptx' => 'Microsoft PowerPoint',
    ],

    /*
    |--------------------------------------------------------------------------
    | php.ini Overrides
    |--------------------------------------------------------------------------
    */
    'php_ini_overrides' => [
        'memory_limit' => '256M',
    ],
];
