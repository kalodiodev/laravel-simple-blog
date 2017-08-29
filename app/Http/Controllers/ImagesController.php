<?php

namespace App\Http\Controllers;

use App\ImageTrait;

class ImagesController extends Controller
{
    use ImageTrait;
    
    /**
     * Get articles featured image
     *
     * @param $filename
     * @return mixed
     */
    public function featured($filename)
    {
        $file = $this->loadImage($filename, ArticlesController::FEATURED_IMAGES_FOLDER);

        return $file == null ? abort(404) : response()->file($file);
    }

    /**
     * Get avatar image
     *
     * @param $filename
     */
    public function avatar($filename)
    {
        $file = $this->loadImage($filename, ProfilesController::$image_folder);

        return $file == null ? abort(404) : response()->file($file);
    }
}
