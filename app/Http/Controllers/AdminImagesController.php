<?php

namespace App\Http\Controllers;

use App\Image;
use App\Services\ArticleImageService;


class AdminImagesController extends Controller
{
    /**
     * Article images service
     *
     * @var ArticleImageService
     */
    protected $articleImageService;
    
    /**
     * Admin Images Controller constructor.
     *
     * @param ArticleImageService $articleImageService
     */
    public function __construct(ArticleImageService $articleImageService)
    {
        $this->middleware('auth');

        $this->articleImageService = $articleImageService;
    }

    /**
     * Index all images
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index()
    {
        $this->isAuthorized('index', Image::class);

        $images = Image::with('user')->latest()->paginate(25);

        return view('images.admin.index', compact('images'));
    }

    /**
     * Show image
     *
     * @param Image $image
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(Image $image)
    {
        $this->isAuthorized('index', $image);

        return view('images.admin.show', compact('image'));
    }

    /**
     * Delete Image
     * 
     * @param Image $image
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Image $image)
    {
        $this->isAuthorized('delete_any', $image);

        $this->articleImageService->delete($image);

        return redirect(route('images.admin.index'));
    }
}