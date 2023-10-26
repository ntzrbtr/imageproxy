<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Image source
    |--------------------------------------------------------------------------
    |
    | This value is the source of the images.
    |
    */

    'source' => rtrim(env('IMAGE_SOURCE', ''), '/'),

    /*
    |--------------------------------------------------------------------------
    | Image cache
    |--------------------------------------------------------------------------
    |
    | This value is the path to the cache directory.
    |
    */

    'cache' => storage_path('images'),

    /*
    |--------------------------------------------------------------------------
    | Image max size
    |--------------------------------------------------------------------------
    |
    | This is the maximum size of images when using the size manipulator.
    |
    */

    'max_size' => env('IMAGE_MAX_SIZE', 2000),

    /*
    |--------------------------------------------------------------------------
    | Image driver
    |--------------------------------------------------------------------------
    |
    | This is the driver to use; allowed values are 'gd' or 'imagick'.
    |
    */

    'driver' => env('IMAGE_DRIVER', 'gd'),

    /*
    |--------------------------------------------------------------------------
    | Skip SSL verification
    |--------------------------------------------------------------------------
    |
    | Shall we skip SSL verification when fetching images?
    |
    */

    'no_verify' => (bool) env('IMAGE_NO_VERIFY', false),

    /*
    |--------------------------------------------------------------------------
    | Format support
    |--------------------------------------------------------------------------
    |
    | Shall we use alternative image formats if possible?
    |
    */

    'use_avif' => (bool) env('IMAGE_USE_AVIF', false),
    'use_webp' => (bool) env('IMAGE_USE_WEBP', false),

];
