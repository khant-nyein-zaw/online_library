<?php

namespace App\Http\Controllers;

use App\Enums\IssuedBookStatus;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    // get all authenticated users with role member
    public function index()
    {
        $users = User::where(function ($query) {
            $query->where('id', auth()->user()->id)
                ->orWhere('role_id', 2);
        })
            ->with(['issuedBooks' => function ($query) {
                $query->where('status', IssuedBookStatus::Overdue);
            }, 'role'])
            ->withCount('issuedBooks')
            ->latest()
            ->get();
        $roles = Role::all();
        return view('admin.member.index', compact('users', 'roles'));
    }

    // change role to librarian|admin
    public function changeRole(Request $request)
    {
        $user = User::find($request->userId);
        $user->role_id = $request->roleId;
        $user->save();

        return response()->json([
            'success' => 'Role has been changed'
        ]);
    }
}
