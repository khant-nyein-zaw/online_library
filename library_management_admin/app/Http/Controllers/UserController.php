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
        dd(User::with('role')->get()->toArray());
    }
}
