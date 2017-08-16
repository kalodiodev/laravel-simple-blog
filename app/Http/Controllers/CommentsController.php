<?php

namespace App\Http\Controllers;

use App\Article;
use App\Comment;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CommentRequest;

class CommentsController extends Controller
{
    /**
     * CommentsController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Store comment
     * 
     * @param $slug
     * @param CommentRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store($slug, CommentRequest $request)
    {
        $article = Article::whereSlug($slug)->firstOrFail();

        $article->comments()->create([
            'body' => $request->get('body'),
            'user_id' => Auth::user()->id
        ]);

        return redirect()->back();
    }

    /**
     * Delete comment
     * 
     * @param Comment $comment
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(Comment $comment)
    {
        $comment->delete();
        
        return redirect()->back();
    }
}
