<?php

namespace App\Http\Controllers;

use App\User;
use App\ImageTrait;
use App\Http\Requests\ProfileRequest;


class ProfilesController extends Controller
{
    use ImageTrait;
    
    const AVATAR_IMAGES_FOLDER = 'images/avatar/';
    const IMAGE_QUALITY = 60;
    const IMAGE_WIDTH = 120;
    const IMAGE_HEIGHT = 120;

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

    /**
     * Update user profile
     *
     * @param User $user
     * @param ProfileRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(User $user, ProfileRequest $request)
    {
        $this->isAuthorized('update', $user);

        $data = [
            'name' => $request->get('name'),
            'about' => $request->get('about'),
            'country' => $request->get('country'),
            'profession' => $request->get('profession')
        ];

        // Remove avatar
        if($request->has('removeavatar'))
        {
            $this->deleteImage($user->avatar, self::AVATAR_IMAGES_FOLDER);
            $data['avatar'] = null;
        }

        // Update avatar
        if(($request->hasFile('avatar') && (! $request->has('removeavatar'))))
        {
            $data['avatar'] = $this->updateImage($user->avatar, $request->file('avatar'),
                self::AVATAR_IMAGES_FOLDER, self::IMAGE_WIDTH, self::IMAGE_HEIGHT, self::IMAGE_QUALITY);
        }

        $user->update($data);

        return redirect(route('profile.show', ['user' => $user->id]));
    }
}