<?php

namespace App\Http\Controllers;

use App\Role;
use App\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
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
}
