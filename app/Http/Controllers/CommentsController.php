<?php

namespace App\Http\Controllers;

use App\Article;
use App\Comment;
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
        $this->isAuthorized('create', Comment::class);

        $article = Article::whereSlug($slug)->firstOrFail();

        $article->comments()->create([
            'body' => $request->get('body'),
            'user_id' => Auth::user()->id
        ]);

        session()->flash('message', __('comments.flash.posted'));

        return redirect()->route('article', ['slug' => $article->slug]);
    }

    /**
     * Edit Comment
     *
     * @param Comment $comment
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws AuthorizationException
     */
    public function edit(Comment $comment)
    {
        $this->isAuthorized('update', $comment);

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
        $this->isAuthorized('update', $comment);

        $comment->update([
           'body' => $request->get('body')
        ]);

        session()->flash('message', __('comments.flash.updated'));

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
        $this->isAuthorized('delete', $comment);

        $comment->delete();

        session()->flash('message', __('comments.flash.deleted'));
        
        return redirect()->back();
    }
}
