<?php

namespace App\Http\Controllers;

use App\Tag;
use App\Comment;
use App\Article;
use App\Http\Requests\ArticleRequest;
use App\Services\FeaturedImageService;
use Illuminate\Auth\Access\AuthorizationException;

class ArticlesController extends Controller
{
    /**
     * Featured Images Service
     *
     * @var FeaturedImageService
     */
    protected $featuredImageService;

    /**
     * ArticlesController constructor.
     *
     * @param FeaturedImageService $featuredImageService
     */
    public function __construct(FeaturedImageService $featuredImageService)
    {
        $this->middleware('auth')->except(['show']);

        $this->featuredImageService = $featuredImageService;
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

        $featured = $this->featuredImageService
            ->store($request->file('image'), auth()->user(), false, false);

        $article_data = [
            'title' => $request->get('title'),
            'description' => $request->get('description'),
            'keywords' => $request->get('keywords'),
            'body' => $request->get('body'),
            'user_id' => auth()->id(),
            'image' => $featured
        ];
        
        // Create article
        $article = Article::create($article_data);

        // Attach tags to article
        $article->tags()->attach($request->get('tags'));

        session()->flash('message', 'Article has been posted!');

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
        
        $imageFilename = $this->featuredImageService->update(
            $article->image, $request->file('image'), auth()->user(), $request->has('removeimage'));

        $article->update([
            'title' => $request->get('title'),
            'description' => $request->get('description'),
            'keywords' => $request->get('keywords'),
            'body' => $request->get('body'),
            'image' => $imageFilename
        ]);

        // Sync article tags
        $article->tags()->sync($request->get('tags'));

        session()->flash('message', 'Article has been updated!');

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

        $featured = $article->image;
        $article->delete();
        $this->featuredImageService->delete($featured);

        session()->flash('message', 'Article has been deleted!');

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
}
