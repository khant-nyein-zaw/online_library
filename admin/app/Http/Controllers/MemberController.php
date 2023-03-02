<?php

namespace App\Http\Controllers;

use App\Models\User;

class MemberController extends Controller
{
    /**
     * get all the members
     */
    public function index()
    {
        $users = User::whereRelation('role', 'main_role', 'member')->withCount('issuedBooks')->get();
        // dd($users->toArray());
        return view('admin.user.index', compact('users'));
    }
}
