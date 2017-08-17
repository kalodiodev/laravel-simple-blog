<?php

namespace App\Http\Controllers;

use App\Article;
use App\Comment;
use App\Permission;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CommentRequest;
use Illuminate\Auth\Access\AuthorizationException;

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
     * @throws AuthorizationException
     */
    public function store($slug, CommentRequest $request)
    {
        if(Gate::denies('create', Comment::class))
        {
            throw new AuthorizationException('You are not authorized for this action');
        }

        $article = Article::whereSlug($slug)->firstOrFail();

        $article->comments()->create([
            'body' => $request->get('body'),
            'user_id' => Auth::user()->id
        ]);

        return redirect()->route('article', ['slug' => $article->slug]);
    }
    
    public function edit(Comment $comment)
    {
        if(Gate::denies('update', $comment))
        {
            throw new AuthorizationException('You are not authorized for this action');
        }

        return view('comments.edit', compact('comment'));
    }

    /***
     * Update comment
     *
     * @param Comment $comment
     * @param CommentRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws AuthorizationException
     */
    public function update(Comment $comment, CommentRequest $request)
    {
        if(Gate::denies('update', $comment))
        {
            throw new AuthorizationException('You are not authorized for this action');
        }

        $comment->update([
           'body' => $request->get('body')
        ]);

        return redirect()->route('article', ['slug' => $comment->article->slug]);
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
        if(Gate::denies('delete', $comment))
        {
            throw new AuthorizationException('You are not authorized for this action');
        }
        
        $comment->delete();
        
        return redirect()->back();
    }
}
