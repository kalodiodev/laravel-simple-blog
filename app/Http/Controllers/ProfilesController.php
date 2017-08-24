<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class ProfilesController extends Controller
{
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
}