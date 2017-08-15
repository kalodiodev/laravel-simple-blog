<?php

namespace App\Http\Controllers;

use App\Tag;
use App\Article;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\ArticleRequest;


class ArticlesController extends Controller
{
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
        if(Gate::denies('create', Article::class))
        {
            throw new AuthorizationException('You are not authorized for this action');
        }

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
        if(Gate::denies('create', Article::class))
        {
            throw new AuthorizationException('You are not authorized for this action');
        }
        
        // Create article
        $article = Article::create([
            'title' => $request->get('title'),
            'description' => $request->get('description'),
            'keywords' => $request->get('keywords'),
            'body' => $request->get('body'),
            'user_id' => auth()->id()
        ]);

        // Attach tags to article
        $article->tags()->attach($request->get('tags'));

        return redirect("/article/" . $article->slug);
    }

    /**
     * Edit article
     *
     * @throws AuthorizationException
     */
    public function edit($slug)
    {
        $tags = Tag::all();
        $article = $this->retrieveArticle($slug);

        if(Gate::denies('update', $article))
        {
            throw new AuthorizationException('You are not authorized for this action');
        }

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

        if(Gate::denies('update', $article))
        {
            throw new AuthorizationException('You are not authorized for this action');
        }

        $data = [
            'title' => $request->get('title'),
            'description' => $request->get('description'),
            'keywords' => $request->get('keywords'),
            'body' => $request->get('body')
        ];

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

        return view('articles.show', compact('article'));
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

        if(Gate::denies('delete', $article))
        {
            throw new AuthorizationException('You are not authorized for this action');
        }

        $article->delete();

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
