<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\MakeLendRequest;
use App\Models\LendRequest;

class LendRequestController extends Controller
{

    public function store(MakeLendRequest $request)
    {
        LendRequest::create($request->validated());
        return response()->noContent();
    }
}
