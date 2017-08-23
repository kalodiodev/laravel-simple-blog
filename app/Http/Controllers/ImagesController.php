<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;

class ImagesController extends Controller
{
    /**
     * Get articles featured image
     *
     * @param $filename
     * @return mixed
     */
    public function featured($filename)
    {
        if(! Storage::has(ArticlesController::FEATURED_IMAGES_FOLDER . $filename))
        {
            // File does not exist
            abort(404);
        }

        return response()->file(
            Storage::path(ArticlesController::FEATURED_IMAGES_FOLDER . $filename)
        );
    }
}
