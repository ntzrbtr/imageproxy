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
     * @param string $filename
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
     */
    public function __invoke(string $filename): \Symfony\Component\HttpFoundation\StreamedResponse
    {
        // Split away size parameter at the end of the filename.
        $width = null;
        if (preg_match('~^(.*)/(\d+)$~', $filename, $matches)) {
            $filename = $matches[1];
            $width = (int)$matches[2];
        }

        // Compose parameters.
        $params = [];
        if ($width) {
            $params['w'] = $width;
        }

        return $this->glide->getImageResponse($filename, $params);
    }
}
