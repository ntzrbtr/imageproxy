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

];
