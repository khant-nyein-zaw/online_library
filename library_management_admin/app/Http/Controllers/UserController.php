<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * get all the users
     */
    public function index()
    {
        $users = User::with('role')->get();
        dd($users->toArray());
    }
}
