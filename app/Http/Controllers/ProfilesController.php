<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class ProfilesController extends Controller
{
    /**
     * ProfilesController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth')->except(['show']);
    }

    /**
     * Show user's profile
     * 
     * @param User $user
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(User $user)
    {
        $articles = $user->articles()
            ->latest()
            ->get();
        
        $comments = $user->comments()
            ->with('article')
            ->latest()
            ->limit(10)
            ->get();
        
        return view('profiles.show', compact('user', 'articles', 'comments'));
    }

    /**
     * Edit user's profile
     * 
     * @param User $user
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(User $user)
    {
        $this->isAuthorized('update', $user);

        return view('profiles.edit', compact('user'));
    }
}