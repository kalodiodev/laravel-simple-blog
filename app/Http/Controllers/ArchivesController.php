<?php

namespace App\Http\Controllers;

use App\Article;

class ArchivesController extends Controller
{
    /**
     * Show articles of year, month
     *
     * @param $year
     * @param $month
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index($year, $month = null)
    {
        if(! isset($year))
        {
            return redirect()->route('home');
        }

        $articles = Article::ofDate($year, $month)->simplePaginate(10);

        return view('home', compact('articles'));
    }

}