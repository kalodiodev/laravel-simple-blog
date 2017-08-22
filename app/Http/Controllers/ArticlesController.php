<?php

namespace App\Http\Controllers;

use App\Tag;
use App\Comment;
use App\Article;
use App\Http\Requests\ArticleRequest;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;


class ArticlesController extends Controller
{
    const FEATURED_IMAGES_FOLDER = 'images/featured/';
    const IMAGE_QUALITY = 60;
    const IMAGE_WIDTH = 800;

    /**
     * ArticlesController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth')->except(['show']);
    }

    /**
     * Create article
     *
     * @throws AuthorizationException
     */
    public function create()
    {
        $this->isAuthorized('create', Article::class);

        $tags = Tag::all();

        return view('articles.create', compact('tags'));
    }

    /**
     * Store article
     *
     * @param ArticleRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws AuthorizationException
     */
    public function store(ArticleRequest $request)
    {
        $this->isAuthorized('create', Article::class);

        $article_data = [
            'title' => $request->get('title'),
            'description' => $request->get('description'),
            'keywords' => $request->get('keywords'),
            'body' => $request->get('body'),
            'user_id' => auth()->id(),
        ];

        if($request->hasFile('image'))
        {
            $article_data['image'] = $this->saveImage($request);
        }
        
        // Create article
        $article = Article::create($article_data);

        // Attach tags to article
        $article->tags()->attach($request->get('tags'));

        return redirect("/article/" . $article->slug);
    }

    /**
     * Edit article
     *
     * @param $slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws AuthorizationException
     */
    public function edit($slug)
    {
        $tags = Tag::all();
        $article = $this->retrieveArticle($slug);

        $this->isAuthorized('update', $article);

        return view('articles.edit', compact('article', 'tags'));
    }

    /**
     * Update article
     *
     * @param $slug
     * @param ArticleRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws AuthorizationException
     */
    public function update($slug, ArticleRequest $request)
    {
        $article = $this->retrieveArticle($slug);

        $this->isAuthorized('update', $article);

        $data = [
            'title' => $request->get('title'),
            'description' => $request->get('description'),
            'keywords' => $request->get('keywords'),
            'body' => $request->get('body')
        ];

        $data['image'] = $this->updateImage($request, $article);

        // Update article
        $article->update($data);

        // Sync article tags
        $article->tags()->sync($request->get('tags'));

        return redirect('/article/' . $article->slug);
    }
    
    /**
     * Show Article
     *
     * @param $slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($slug)
    {
        $article = $this->retrieveArticle($slug);
        
        $comments = Comment::whereArticleId($article->id)
            ->latest()
            ->paginate(10);

        return view('articles.show', compact('article','comments'));
    }

    /**
     * Delete Article
     *
     * @param $slug
     * @return \Illuminate\Http\RedirectResponse
     * @throws AuthorizationException
     */
    public function destroy($slug)
    {
        $article = $this->retrieveArticle($slug);
        $this->isAuthorized('delete', $article);

        $image_filename = $article->image;
        $article->delete();
        $this->deleteImage($image_filename);

        return redirect()->route('home');
    }
    
    /**
     * Retrieve article by slug
     * 
     * @param $slug
     * @return mixed
     */
    private function retrieveArticle($slug)
    {
        return Article::whereSlug($slug)->firstOrFail();
    }

    /**
     * Update image
     *
     * @param ArticleRequest $request
     * @param Article $article
     * @return string filename
     */
    private function updateImage(ArticleRequest $request, Article $article)
    {
        $filename = $article->image;

        if($request->has('removeimage'))
        {
            $this->deleteImage($article->image);
            $filename = null;
        }

        if(($request->hasFile('image')) && (! $request->has('removeimage')))
        {
            $old_image = $article->image;
            $filename = $this->saveImage($request);
            $this->deleteImage($old_image);
        }

        return $filename;
    }

    /**
     * Save Image
     * 
     * @param ArticleRequest $request
     * @return string
     */
    private function saveImage(ArticleRequest $request)
    {
        $image = $request->file('image');

        $filename = time() . '-' . $request->file('image')->getClientOriginalName();

        Image::make($image)->resize(self::IMAGE_WIDTH, null, function ($constraint) {
            $constraint->aspectRatio();
        })->save(storage_path('app/' . self::FEATURED_IMAGES_FOLDER . $filename), self::IMAGE_QUALITY);
        
        return $filename;
    }

    /**
     * Delete image from storage
     *
     * @param $filename
     */
    private function deleteImage($filename)
    {
        if(($filename == null) || ($filename == ''))
        {
            return;
        }

        if(Storage::disk('local')->has(self::FEATURED_IMAGES_FOLDER . $filename))
        {
            Storage::disk('local')->delete(self::FEATURED_IMAGES_FOLDER . $filename);
        }
    }
}
