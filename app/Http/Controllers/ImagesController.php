<?php

namespace App\Http\Controllers;

use App\ImageTrait;
use Illuminate\Http\Request;


class ImagesController extends Controller
{
    use ImageTrait;

    /**
     * ImagesController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth')->only('store');
    }

    /**
     * Get articles featured image
     *
     * @param $filename
     * @return mixed
     */
    public function featured($filename)
    {
        $file = $this->loadImage($filename, ArticlesController::$image_folder);

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

    /**
     * Get article image
     *
     * @param $filename
     */
    public function article($filename)
    {
        $file = $this->loadImage($filename, ArticlesController::$articles_image_folder);

        return $file == null ? abort(404) : response()->file($file);
    }

    /**
     * Save image
     *
     * @param Request $request
     * @return string
     */
    public function articleStore(Request $request)
    {
        // TODO: check authorized

        if(! $request->hasFile('file'))
        {
            abort(400);
        }

        $image = $request->file('file');
        $filename = $this->uploadImage($image, ArticlesController::$articles_image_folder, 75);

        return ArticlesController::$articles_image_folder . $filename;
    }
}