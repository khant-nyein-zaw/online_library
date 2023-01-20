<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Shelf;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        return view("dashboard");
    }
}
