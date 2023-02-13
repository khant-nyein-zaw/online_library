<?php

namespace App\Http\Controllers;

use App\Models\User;

class UserController extends Controller
{
    /**
     * get all the users
     */
    public function index()
    {
        $users = User::whereRelation('role', 'role_name', 'user')->withCount('borrowings')->get();
        return view('user.index', compact('users'));
    }
}
