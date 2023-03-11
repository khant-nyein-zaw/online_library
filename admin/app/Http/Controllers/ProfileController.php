<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Image;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    public function index()
    {
        $adminData = User::with('image')->firstWhere('id', auth()->user()->id);
        return view('admin.profile.index', compact('adminData'));
    }

    public function update(Request $request, int $id)
    {
        $inputs = Validator::make($request->all(), [
            'name' => 'required|min:3|max:256',
            'email' => 'required|string|email',
            'phone' => 'required|numeric',
            'address' => 'required|min:6|max:256'
        ])->validate();

        User::find($id)->update($inputs);
        return back()->with('success', 'Your profile was updated');
    }

    public function uploadPhoto(Request $request, int $id)
    {
        Validator::make($request->all(), [
            'image' => ['required', File::image()]
        ])->validate();

        $newFileName = uniqid() . "_" . $request->file('image')->getClientOriginalName();

        $imageExists = Image::where('imageable_id', $id)->exists() ?
            (Image::firstWhere('imageable_id', $id)->imageable_type === User::class ? true : false) : false;

        if ($imageExists) {
            // delete current file from storage
            $filename = Image::where('imageable_id', $id)->pluck('filename')->first();
            Storage::delete('public/' . $filename);
            // update new image
            $request->file('image')->storeAs('public', $newFileName);
            Image::where('imageable_id', $id)->update([
                'filename' => $newFileName
            ]);
        } else {
            $request->file('image')->storeAs('public', $newFileName);
            Image::create([
                'filename' => $newFileName,
                'imageable_id' => $id,
                'imageable_type' => User::class
            ]);
        }

        return back()->with('success', 'Your profile photo was updated');
    }

    public function resetPhoto($id)
    {
        $filename = Image::where(function (Builder $query) use ($id) {
            $query->where('imageable_id', $id)
                ->where('imageable_type', User::class);
        })->pluck('filename')->first();

        Storage::delete('public/' . $filename);
        $user = User::find($id);
        $user->image()->delete();
        return back()->with('deleted', 'User profile photo was removed');
    }

    public function resetPassword($id, Request $request)
    {
        $user = User::find($id);

        Validator::make($request->all(), [
            'current_password' => 'required',
            'password' => ['required', Password::min(8)->mixedCase()->numbers(), 'confirmed', 'different:current_password'],
            'password_confirmation' => ['required']
        ])->validate();

        if (Hash::check($request->current_password, $user->password)) {
            $user->forceFill([
                'password' => Hash::make($request->password)
            ])->save();

            $request->session()->flash('success', 'Password was updated');
            return back();
        }

        $request->session()->flash('error', 'Password does not match');
        return back();
    }
}
