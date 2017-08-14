<?php

namespace App\Http\Controllers;

use App\Tag;

class TagsController extends Controller
{
    /**
     * Index articles of tag
     *
     * @param Tag $tag
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Tag $tag)
    {
        $articles = $tag->articles()
            ->latest()
            ->simplePaginate(10);

        return view('home', compact('articles'));
    }
}