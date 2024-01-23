<?php

namespace App\Http\Controllers;

use App\Http\Requests\PasswordRequest;
use App\Http\Requests\ProfilePictureRequest;
use App\Http\Requests\ProfileRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function show($username)
    {
        $user = User::where('username', $username)->first();

        if (!$user) {
            return redirect()->back()->with('error', 'User not found');
        }

        $posts = User::find($user->id)->posts()->orderBy('created_at', 'desc')->get();

        return view('profiles.show', compact('user', 'posts'));
    }

    public function edit()
    {
        if (auth()->check()) {
            $user = User::find(auth()->user()->id);
        } else {
            dd('You are not logged in');
        }

        return view('profiles.edit', compact('user'));
    }

    public function update(ProfileRequest $request)
    {
        $request->validated();

        $user = User::find(auth()->user()->id);

        $user->update([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'bio' => $request->bio,
            'gender' => $request->input('selectedGender'),
        ]);

        return redirect()->route('profiles.edit')->with('status', 'Profile updated successfully');
    }

    public function updateProfilePicture(ProfilePictureRequest $request)
    {
        $request->validated('avatar');

        $user = User::find(auth()->user()->id);

        if ($request->hasFile('avatar')) {
            $file = $request->file('avatar');
            $fileName = time() . '-' . $file->getClientOriginalName();
            $file->storeAs('public', $fileName, 'public');

            $user->update([
                'avatar' => 'public/' . $fileName,
            ]);
        }

        return redirect()->route('profiles.edit')->with('status', 'Profile picture updated successfully');
    }

    public function editPassword()
    {
        if (auth()->check()) {
            $user = User::find(auth()->user()->id);
        } else {
            dd('You are not logged in');
        }
        return view('profiles.edit-password', compact('user'));
    }

    public function updatePassword(PasswordRequest $request)
    {
        $request->validated();

        $user = User::find(auth()->user()->id);

        $user->update([
            'password' => Hash::make($request->password),
            'password_changed_at' => date('Y-m-d'),
        ]);

        $user->save();

        return redirect()->route('users.login')->with('status', 'Password updated successfully');
    }

    public function deleteProfile()
    {
        $user = User::find(auth()->user()->id);

        $user->delete();

        return redirect()->route('users.register')->with('status', 'Profile deleted successfully');
    }

    public function search(Request $request)
    {
        $query = $request->query->get('query');
        $users = User::where('username', 'LIKE', "%{$query}%")
            ->orWhere('name', 'LIKE', "%{$query}%")
            ->get();

        return response()->json($users);
    }
}
