<?php

namespace App\Http\Controllers;

use App\Http\Requests\PasswordRequest;
use App\Http\Requests\ProfilePictureRequest;
use App\Http\Requests\ProfileRequest;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function show($username): View
    {
        $user = User::where('username', $username)->first();

        !$user ? abort(404, 'User not found') : null;

        $posts = User::find($user->id)->posts()->orderBy('created_at', 'desc')->get();

        return view('profiles.show', compact('user', 'posts'));
    }

    public function edit(): View
    {
        auth()->check() ? $user = User::find(auth()->user()->id) : null;

        return view('profiles.edit', compact('user'));
    }

    public function update(ProfileRequest $request): RedirectResponse
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

    public function updateProfilePicture(ProfilePictureRequest $request): RedirectResponse
    {
        $request->validated();

        $user = User::find(auth()->user()->id);

        if ($request->hasFile('avatar') && $request->file('avatar')->isValid()) {
            $file = $request->file('avatar');
            $fileName = time() . '-' . $file->getClientOriginalName();
            $file->storeAs('public', $fileName, 'public');

            $user->update([
                'avatar' => 'public/' . $fileName,
            ]);

            dd($user);
        }
        return redirect()->route('profiles.edit')->with('status', 'Profile picture updated successfully');
    }

    public function editPassword(): View
    {
        auth()->check() ? $user = User::find(auth()->user()->id) : null;
        
        return view('profiles.edit-password', compact('user'));
    }

    public function updatePassword(PasswordRequest $request): RedirectResponse
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

    public function deleteProfile(): RedirectResponse
    {
        $user = User::find(auth()->user()->id);

        $user->delete();

        return redirect()->route('users.register')->with('status', 'Profile deleted successfully');
    }

    public function search(Request $request): JsonResponse
    {
        $query = $request->query->get('query');
        $users = User::where('username', 'LIKE', "%{$query}%")
            ->orWhere('name', 'LIKE', "%{$query}%")
            ->get();

        return response()->json($users);
    }
}
