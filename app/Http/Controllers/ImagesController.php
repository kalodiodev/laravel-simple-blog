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
        if(! Storage::disk('local')->has(ArticlesController::FEATURED_IMAGES_FOLDER . $filename))
        {
            abort(404);
        }

        return response()->file(storage_path('app/' .
            ArticlesController::FEATURED_IMAGES_FOLDER . $filename));
    }
}
