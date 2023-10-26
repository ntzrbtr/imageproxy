<?php

declare(strict_types=1);

namespace App\Strategies;

/**
 * Interface for format strategies
 */
interface FormatStrategyInterface
{
    /**
     * Get image format to use.
     */
    public function getFormat(\Illuminate\Http\Request $request, string $filename): ?string;
}
