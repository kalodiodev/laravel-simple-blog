<?php

namespace App\Http\Controllers;

use App\Image;
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
        $this->middleware('auth')->only(['store','index','delete','show', 'all']);

        $this->articleImageService = $articleImageService;
        $this->avatarImageService = $avatarImageService;
    }

    /**
     * Index all images
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function all()
    {
        $this->isAuthorized('index', Image::class);

        $images = Image::with('user')->latest()->paginate(25);

        return view('images.all', compact('images'));
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
        }

        return redirect(route('images.index'));
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