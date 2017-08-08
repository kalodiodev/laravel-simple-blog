<?php

namespace App\Http\Controllers;

use App\Article;
use App\Http\Requests\ArticleRequest;
use App\Tag;
use Illuminate\Http\Request;
use Illuminate\Pagination\PaginationServiceProvider;
use Illuminate\Support\Facades\Auth;

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
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $tags = Tag::all();

        return view('articles.create', compact('tags'));
    }

    /**
     * Store article
     *
     * @param ArticleRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(ArticleRequest $request)
    {
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
     * @param $slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($slug)
    {
        $tags = Tag::all();

        $auth = auth()->user();
        $article = $auth->articles()
            ->whereSlug($slug)
            ->firstOrFail();

        return view('articles.edit', compact('article', 'tags'));
    }

    /**
     * Update article
     *
     * @param $slug
     * @param ArticleRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update($slug, ArticleRequest $request)
    {
        $article = auth()->user()->articles()
            ->whereSlug($slug)
            ->firstOrFail();

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
        $article = Article::whereSlug($slug)->firstOrFail();

        return view('articles.show', compact('article'));
    }
}
