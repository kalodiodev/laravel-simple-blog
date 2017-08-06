<?php

namespace App\Http\Controllers;

use App\Article;
use Illuminate\Http\Request;

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
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store()
    {
        Article::create([
            'title' => request('title'),
            'description' => request('description'),
            'keywords' => request('keywords'),
            'body' => request('body')
        ]);

        return redirect("/");
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
