<?php

namespace App\Http\Controllers;

use App\Article;
use App\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentsController extends Controller
{
    /**
     * CommentsController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store($slug, Request $request)
    {
        $article = Article::whereSlug($slug)->firstOrFail();

        $article->comments()->create([
            'body' => $request->get('body'),
            'user_id' => Auth::user()->id
        ]);

        return redirect()->back();
    }
    
    public function destroy(Comment $comment)
    {
        $comment->delete();
        
        return redirect()->back();
    }
}
