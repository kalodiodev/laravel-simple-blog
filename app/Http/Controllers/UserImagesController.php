<?php

namespace App\Http\Controllers;

use App\Image;
use App\Services\ArticleImageService;


class UserImagesController extends Controller
{
    /**
     * Article images service
     *
     * @var ArticleImageService
     */
    protected $articleImageService;

    /**
     * UserImagesController constructor.
     *
     * @param ArticleImageService $articleImageService
     */
    public function __construct(ArticleImageService $articleImageService)
    {
        $this->middleware('auth');

        $this->articleImageService = $articleImageService;
    }
    
    /**
     * Index auth user images
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $this->isAuthorized('index_own', Image::class);

        $images = Image::where('user_id', auth()->user()->id)->paginate(15);

        return view('images.index', compact('images'));
    }

    /**
     * Show user's image
     *
     * @param Image $image
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(Image $image)
    {
        $this->isAuthorized('view', $image);

        return view('images.show', compact('image'));
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
            $this->articleImageService->delete($image);

            session()->flash('message', 'Image has been deleted!');
        }

        return redirect(route('images.index'));
    }
}