<?php

declare(strict_types=1);

namespace App\Strategies;

/**
 * Interface for format strategies
 */
interface FormatStrategyInterface
{
    /**
     * Get image format to use:
     * - return null to leave format as-is
     * - otherwise return one of the formats listed in \League\Glide\Manipulators\Encode::supportedFormats()
     */
    public function getFormat(\Illuminate\Http\Request $request, string $filename): ?string;
}
