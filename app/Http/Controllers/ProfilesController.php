<?php

namespace App\Http\Controllers;

use App\User;
use App\Services\AvatarImageService;
use App\Http\Requests\ProfileRequest;


class ProfilesController extends Controller
{
    /**
     * Avatar image service
     */
    protected $avatarImageService;

    /**
     * ProfilesController constructor.
     *
     * @param AvatarImageService $avatarImageService
     */
    public function __construct(AvatarImageService $avatarImageService)
    {
        $this->middleware('auth')->except(['show']);
        
        $this->avatarImageService = $avatarImageService;
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
        $this->isAuthorized('update_profile', $user);

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
        $this->isAuthorized('update_profile', $user);

        $avatarFilename = $this->avatarImageService->update(
            $user->avatar, $request->file('avatar'), $user, $request->has('removeavatar'), true);

        $data = [
            'name' => $request->get('name'),
            'about' => $request->get('about'),
            'country' => $request->get('country'),
            'profession' => $request->get('profession'),
            'avatar' => $avatarFilename
        ];

        $user->update($data);

        session()->flash('message', __('profile.flash.updated'));

        return redirect(route('profile.show', ['user' => $user->id]));
    }
}