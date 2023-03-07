<?php

namespace App\Http\Controllers;

use App\Enums\IssuedBookStatus;
use App\Models\User;

class MemberController extends Controller
{
    /**
     * get all the members
     */
    public function index()
    {
        $users = User::whereRelation('role', 'main_role', 'member')->with(['issuedBooks' => function ($query) {
            $query->where('status', IssuedBookStatus::Overdue);
        }])
            ->withCount('issuedBooks')->get();
        return view('admin.user.index', compact('users'));
    }
}
