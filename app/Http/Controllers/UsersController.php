<?php

namespace App\Http\Controllers;

use App\User;
use App\Role;
use App\Http\Requests\UserRequest;
use App\Services\AvatarImageService;

class UsersController extends Controller
{
    /**
     * Avatar image service
     */
    protected $avatarImageService;

    /**
     * UsersController constructor.
     *
     * @param AvatarImageService $avatarImageService
     */
    public function __construct(AvatarImageService $avatarImageService)
    {
        $this->middleware('auth');

        $this->avatarImageService = $avatarImageService;
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
     * Create user
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create()
    {
        $this->isAuthorized('create', User::class);

        $roles = Role::all();

        return view('users.create', compact('roles'));
    }

    /**
     * Store user
     *
     * @param UserRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(UserRequest $request)
    {
        $this->isAuthorized('create', User::class);

        $avatarFilename = $this->avatarImageService->store(
            $request->file('avatar'), auth()->user(), false, false);

        $user = User::create([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'about' => $request->get('about'),
            'profession' => $request->get('profession'),
            'country' => $request->get('country'),
            'role_id' => $request->get('role'),
            'avatar' => $avatarFilename,
            'password' => bcrypt($request->get('password'))
        ]);

        session()->flash('message', 'User has been created!');

        return redirect(route('users.show', ['user' => $user->id]));
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

        $avatarFilename = $this->avatarImageService->update(
            $user->avatar, $request->file('avatar'), $user, $request->has('removeavatar'));

        $data = [
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'about' => $request->get('about'),
            'profession' => $request->get('profession'),
            'country' => $request->get('country'),
            'role_id' => $request->get('role'),
            'avatar' => $avatarFilename
        ];

        if($request->has('password'))
        {
            $data['password'] = bcrypt($request->get('password'));
        }

        $user->update($data);

        session()->flash('message', 'User has been updated!');

        return redirect(route('users.show', ['user' => $user->id]));
    }

    /**
     * Show user
     *
     * @param User $user
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(User $user)
    {
        $this->isAuthorized('view', User::class);
        
        return view('users.show', compact('user'));
    }

    /**
     * Delete User
     *
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Exception
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(User $user)
    {
        $this->isAuthorized('delete', User::class);

        $avatar = $user->avatar;
        $user->delete();

        $this->avatarImageService->delete($avatar);

        session()->flash('message', 'User has been deleted!');

        return redirect(route('users.index'));
    }
}
