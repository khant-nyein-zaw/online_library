<?php

namespace App\Http\Controllers;

use App\Models\Returning;
use Illuminate\Http\Request;

class ReturningController extends Controller
{
    public function index()
    {
        $returnings = Returning::with(['book', 'user'])->get();
        return view('admin.returning.index', compact('returnings'));
    }
}
