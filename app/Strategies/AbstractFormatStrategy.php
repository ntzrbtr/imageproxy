<?php

declare(strict_types=1);

namespace App\Strategies;

use Illuminate\Http\Request;

/**
 * Abstract format strategy
 */
abstract class AbstractFormatStrategy implements FormatStrategyInterface
{
    /**
     * AbstractFormatStrategy constructor.
     */
    public function __construct(protected \League\Flysystem\FilesystemOperator $source)
    {
    }

    /**
     * Get whether the browser supports WebP.
     */
    protected function browserSupportsWebP(Request $request): bool
    {
        return str_contains($request->header('Accept') ?? '', 'image/webp');
    }

    /**
     * Get whether the browser supports AVIF.
     */
    protected function browserSupportsAVIF(Request $request): bool
    {
        return str_contains($request->header('Accept') ?? '', 'image/avif');
    }
}
