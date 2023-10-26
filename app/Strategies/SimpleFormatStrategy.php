<?php

declare(strict_types=1);

namespace App\Strategies;

/**
 * Simple format strategy
 */
class SimpleFormatStrategy extends AbstractFormatStrategy
{
    /**
     * Mime type detector
     *
     * @var \League\MimeTypeDetection\MimeTypeDetector
     */
    protected \League\MimeTypeDetection\MimeTypeDetector $detector;

    /**
     * SimpleFormatStrategy constructor.
     *
     * @param \League\Flysystem\FilesystemOperator $source
     */
    public function __construct(protected \League\Flysystem\FilesystemOperator $source)
    {
        parent::__construct($source);

        $this->detector = new \League\MimeTypeDetection\ExtensionMimeTypeDetector();
    }

    /**
     * @inheritDoc
     */
    public function getFormat(\Illuminate\Http\Request $request, string $filename): ?string
    {
        // Get mime type from filename.
        $mimeType = $this->detector->detectMimeTypeFromPath($filename);

        // Decide the target format.
        $supportsWebP = $this->browserSupportsWebP($request);
        return match (true) {
            // If we have WebP, then use it for JPEG and PNG images.
            $supportsWebP => match ($mimeType) {
                'image/jpeg', 'image/png' => 'webp',
                default => null,
            },

            // If the browser does NOT support WebP, then use JPEG for WebP images.
            !$supportsWebP => match ($mimeType) {
                'image/webp' => 'jpg',
                default => null,
            },

            // In all other cases, leave the format untouched.
            default => null,
        };
    }
}
