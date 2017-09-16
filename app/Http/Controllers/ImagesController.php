<?php

namespace App\Http\Controllers;

use App\Http\Requests\ImageRequest;
use App\Services\AvatarImageService;
use App\Services\ArticleImageService;


class ImagesController extends Controller
{
    /**
     * Article images service
     * 
     * @var ArticleImageService
     */
    protected $articleImageService;

    /**
     * Avatar image service
     * 
     * @var AvatarImageService
     */
    protected $avatarImageService;

    /**
     * ImagesController constructor.
     *
     * @param ArticleImageService $articleImageService
     * @param AvatarImageService $avatarImageService
     */
    public function __construct(ArticleImageService $articleImageService, 
                                AvatarImageService $avatarImageService)
    {
        $this->middleware('auth')->only(['store']);

        $this->articleImageService = $articleImageService;
        $this->avatarImageService = $avatarImageService;
    }
    
    /**
     * Get avatar image
     *
     * @param $filename
     */
    public function avatar($filename)
    {
        $file = $this->avatarImageService->load($filename);

        return $file == null ? abort(404) : response()->file($file);
    }

    /**
     * Get article image
     *
     * @param $filename
     */
    public function article($filename)
    {
        $file = $this->articleImageService->load($filename);

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
        
        $filename = $this->articleImageService->store($image, auth()->user());

        return $this->articleImageService->folder() . $filename;
    }
}