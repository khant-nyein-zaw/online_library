<?php

namespace App\Http\Controllers\API;

use App\Models\LendRequest;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Builder;
use App\Http\Requests\User\MakeLendRequest;

class LendRequestController extends Controller
{

    public function store(MakeLendRequest $request)
    {
        $recordExists = LendRequest::where(function (Builder $query) use ($request) {
            $query->where('user_id', $request->user()->id)
                ->where('book_id', $request->input('book_id'));
        })->exists();

        if ($recordExists) {
            return response()->json([
                'status' => 'Duplicate record',
                'message' => 'You have already requested to lend this book!'
            ]);
        }

        LendRequest::create($request->validated());
        return response()->noContent();
    }
}
