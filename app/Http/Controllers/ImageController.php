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
     */
    public function __construct(
        protected \League\Glide\Server $glide,
        protected \App\Strategies\FormatStrategyInterface $formatStrategy
    ) {
    }

    /**
     * Handle requests for images.
     */
    public function __invoke(
        \Illuminate\Http\Request $request,
        string $filename
    ): \Symfony\Component\HttpFoundation\StreamedResponse {
        // Split away size parameter at the end of the filename.
        $width = null;
        if (preg_match('~^(.*)/(\d+)$~', $filename, $matches)) {
            $filename = $matches[1];
            $width = (int) $matches[2];
        }

        // Compose parameters.
        $params = [];
        // 1. Resizing.
        if ($width) {
            $params['w'] = $width;
        }
        // 2. Image format.
        $format = $this->formatStrategy->getFormat($request, $filename);
        if ($format) {
            $params['fm'] = $format;
        }

        // Get response.
        $response = $this->glide->getImageResponse($filename, $params);

        // Write log.
        \Illuminate\Support\Facades\Log::channel('image')
            ->debug('Image requested', [
                'filename' => $filename,
                'params' => $params,
                'status' => $response->getStatusCode(),
            ]);

        return $response;
    }
}
