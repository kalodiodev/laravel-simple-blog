<?php

namespace App\Http\Controllers;

use App\Image;
use App\Services\ArticleImageService;
use Illuminate\Http\Request;


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
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Request $request)
    {
        $this->isAuthorized('index', Image::class);

        $images = Image::with('user');

        if($request->has('search'))
        {
            $search = $request->get('search');

            $images = $images->filter($search);
        }

        $images = $images->latest()->paginate(25);

        return view('images.admin.index', compact('images', 'search'));
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
        $this->isAuthorized('view_any', Image::class);

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
        $this->isAuthorized('delete_any', Image::class);

        $this->articleImageService->delete($image);

        session()->flash('message', 'Image has been deleted!');

        return redirect(route('images.admin.index'));
    }
}