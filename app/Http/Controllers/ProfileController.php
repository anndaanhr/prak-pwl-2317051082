<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    /**
     * Display the student profile (old route).
     */
    public function show($Nama, $NPM, $Kelas)
    {
        $photoUrl = null;
        $photoPath = public_path('images/profile.jpg');
        if (file_exists($photoPath)) {
            $photoUrl = asset('images/profile.jpg');
        }

        return view('profile', compact('Nama', 'NPM', 'Kelas', 'photoUrl'));
    }

    /**
     * Handle photo upload (old route).
     */
    public function upload(Request $request)
    {
        $request->validate([
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'Nama' => 'required|string',
            'NPM' => 'required|string',
            'Kelas' => 'required|string',
        ]);

        if ($request->hasFile('photo')) {
            $image = $request->file('photo');
            $imageName = 'profile.jpg';
            $image->move(public_path('images'), $imageName);
        }

        return redirect()->route('profile', [
            'Nama' => $request->Nama,
            'NPM' => $request->NPM,
            'Kelas' => $request->Kelas
        ])->with('success', 'Foto berhasil diupload!');
    }
}
