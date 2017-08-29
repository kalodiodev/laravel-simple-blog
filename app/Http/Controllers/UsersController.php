<?php

namespace App\Http\Controllers;

use App\User;
use App\Role;
use App\Http\Requests\UserRequest;

class UsersController extends ImageUploadController
{
    public static $image_folder = 'images/avatar/';
    protected $image_quality = 60;
    protected $image_height = 120;
    protected $image_width = 120;

    /**
     * UsersController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Index users
     * 
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index()
    {
        $this->isAuthorized('view', User::class);

        $users = User::paginate(25);
        
        return view('users.index', compact('users'));
    }

    /**
     * Edit user
     * 
     * @param User $user
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(User $user)
    {
        $this->isAuthorized('update', User::class);

        $roles = Role::all();
        
        return view('users.edit', compact('user', 'roles'));
    }

    /**
     * Update user
     * 
     * @param User $user
     * @param UserRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(User $user, UserRequest $request)
    {
        $this->isAuthorized('update', User::class);

        $avatarFilename = $this->updateImage(
            $request->file('avatar'), $user->avatar, $request->has('removeavatar'));

        $user->update([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'about' => $request->get('about'),
            'profession' => $request->get('profession'),
            'country' => $request->get('country'),
            'role_id' => $request->get('role'),
            'avatar' => $avatarFilename
        ]);

        return redirect(route('users.index'));
    }
}
