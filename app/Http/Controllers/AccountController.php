<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Routing\Controller;

class AccountController extends Controller
{
    /**
     * Show the account settings form.
     */
    public function showSettings()
    {
        return view('account.settings');
    }

    /**
     * Update the user's account settings.
     */
    public function updateSettings(Request $request)
    {
        $user = Auth::user();
        
        // Validate the request
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'current_password' => 'nullable|required_with:new_password|string',
            'new_password' => 'nullable|required_with:current_password|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Update name
        $user->name = $request->name;

        // Handle profile picture upload
        if ($request->hasFile('profile_picture')) {
            // Delete old profile picture if exists
            if ($user->profile_picture && Storage::exists($user->profile_picture)) {
                Storage::delete($user->profile_picture);
            }
            
            // Store new profile picture
            $path = $request->file('profile_picture')->store('profile_pictures', 'public');
            $user->profile_picture = $path;
        }

        // Handle password change
        if ($request->new_password) {
            // Check if current password is correct
            if (!Hash::check($request->current_password, $user->password)) {
                return redirect()->back()
                    ->withErrors(['current_password' => 'The current password is incorrect.'])
                    ->withInput();
            }
            
            // Update password
            $user->password = Hash::make($request->new_password);
        }

        // Save user
        $user->save();

        return redirect()->back()
            ->with('success', 'Account settings updated successfully.');
    }
}