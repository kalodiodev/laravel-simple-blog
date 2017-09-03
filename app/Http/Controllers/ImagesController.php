<?php

namespace App\Http\Controllers;

use App\Image;
use App\ImageTrait;
use App\Http\Requests\ImageRequest;


class ImagesController extends Controller
{
    use ImageTrait;

    /**
     * ImagesController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth')->only(['store','index','delete']);
    }

    /**
     * Index auth user images
     * 
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $this->isAuthorized('index_own', Image::class);

        $images = Image::where('user_id', auth()->user()->id)->get();
        
        return view('images.index', compact('images'));
    }

    /**
     * Delete image
     * 
     * @param $filename
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function delete($filename)
    {
        $image = Image::where('filename', $filename)->first();

        $this->isAuthorized('delete', $image);
        
        if(isset($image)) 
        {
            $this->deleteImage($image->filename, $image->path);
            $this->deleteImage($image->thumbnail, $image->path);
            $image->delete();
        }

        return redirect()->back();
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
     * @param ImageRequest $request
     * @return string
     */
    public function articleStore(ImageRequest $request)
    {
        if(! $request->hasFile('file'))
        {
            abort(400);
        }

        $image = $request->file('file');
        $filename = $this->uploadImage($image, ArticlesController::$articles_image_folder, 75);
        $thumbnail = $this->storeThumbnail($image, $filename, ArticlesController::$articles_image_folder);

        $this->storeImageToDB(auth()->user(), $filename, ArticlesController::$articles_image_folder, $thumbnail);

        return ArticlesController::$articles_image_folder . $filename;
    }

    /**
     * Store image filename to database
     *
     * @param $user
     * @param $filename
     * @param $path
     */
    protected function storeImageToDB($user, $filename, $path, $thumbnail)
    {
        $user->images()->create([
            'filename' => $filename,
            'path' => $path,
            'thumbnail' => $thumbnail
        ]);
    }
}