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
        $user = $request->user();

        // Track changes for logging
        $changes = [];

        if ($request->has('first_name') && $user->first_name != $request->first_name) {
            $changes[] = 'first name: ' . $user->first_name . ' → ' . $request->first_name;
            $user->first_name = $request->first_name;
        }

        if ($request->has('last_name') && $user->last_name != $request->last_name) {
            $changes[] = 'last name: ' . $user->last_name . ' → ' . $request->last_name;
            $user->last_name = $request->last_name;
        }

        if ($request->has('contact_number') && $user->contact_number != $request->contact_number) {
            $changes[] = 'contact number updated';
            $user->contact_number = $request->contact_number;
        }

        if ($request->has('email') && $user->email !== $request->email) {
            $changes[] = 'email: ' . $user->email . ' → ' . $request->email;
            $user->email = $request->email;
            $user->email_verified_at = null;
        }

        $user->save();

        // Log profile update
        if (!empty($changes)) {
            \App\Models\Log::create([
                'account_ID' => $user->account_ID,
                'actions' => 'Profile Update',
                'descriptions' => 'Updated profile: ' . implode(', ', $changes),
                'timestamp' => now(),
            ]);
        }

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current-password'],
        ]);

        $user = $request->user();

        // Log account deletion
        \App\Models\Log::create([
            'account_ID' => $user->account_ID,
            'actions' => 'Account Self-Deletion',
            'descriptions' => 'User ' . $user->first_name . ' ' . $user->last_name . ' deleted their own account',
            'timestamp' => now(),
        ]);

        Auth::logout();
        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

}