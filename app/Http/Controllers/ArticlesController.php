<?php

namespace App\Http\Controllers;

use App\Article;
use App\Http\Requests\ArticleRequest;
use Illuminate\Http\Request;
use Illuminate\Pagination\PaginationServiceProvider;

class ArticlesController extends Controller
{

    /**
     * Create article
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('articles.create');
    }

    /**
     * Store article
     *
     * @param ArticleRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(ArticleRequest $request)
    {
        $article = Article::create([
            'title' => $request->get('title'),
            'description' => $request->get('description'),
            'keywords' => $request->get('keywords'),
            'body' => $request->get('body')
        ]);

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

        $article = Article::whereSlug($slug)->firstOrFail();

        return view('articles.edit', compact('article'));
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
        $article = Article::whereSlug($slug)->firstOrFail();

        $data = [
            'title' => $request->get('title'),
            'description' => $request->get('description'),
            'keywords' => $request->get('keywords'),
            'body' => $request->get('body')
        ];

        $article->update($data);

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
