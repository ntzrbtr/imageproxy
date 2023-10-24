<?php

declare(strict_types=1);

namespace App\Http\Controllers;

/**
 * Controller for image handling
 */
class ImageController extends Controller
{
    /**
     * Handle requests for images.
     *
     * @param \Illuminate\Http\Request $request
     * @param string $filename
     * @return \Illuminate\Http\Response
     */
    public function __invoke(\Illuminate\Http\Request $request, string $filename): \Illuminate\Http\Response
    {
        $source = config('image.source');

        return response()->json([
            'url' => "$source/$filename",
            'width' => $request->input('width', null),
        ]);
    }
}
