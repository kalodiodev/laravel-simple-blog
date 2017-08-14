<?php

namespace App\Http\Controllers;

use App\Article;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HomeController extends Controller
{

    /**
     * Show home page
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $articles = Article::latest();

        if($year = request('year'))
        {
            $articles->whereYear('created_at', $year);
        }

        if($month = request('month'))
        {
            $articles->whereMonth('created_at', Carbon::parse($month)->month);
        }

        $articles = $articles->simplePaginate(10);

        return view('home', compact('articles'));
    }
}
