<?php

declare(strict_types=1);

namespace App\Http\Controllers;

/**
 * Controller for image handling
 */
class ImageController extends Controller
{
    /**
     * ImageController constructor.
     *
     * @param \League\Glide\Server $glide
     */
    public function __construct(protected \League\Glide\Server $glide)
    {
    }

    /**
     * Handle requests for images.
     *
     * @param \Illuminate\Http\Request $request
     * @param string $filename
     * @return \Illuminate\Http\Response
     */
    public function __invoke(\Illuminate\Http\Request $request, string $filename): \Illuminate\Http\Response
    {
        $width = $request->input('width');
        $params = [];
        if (is_numeric($width)) {
            $params = [
                'w' => (int)$width,
            ];
        }

        return $this->glide->getImageResponse($filename, $params);
    }
}
