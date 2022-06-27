<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function index()
    {
        $user = User::where('id', Auth::id())->get();

        return view('backend.profileSettings', compact('user'));
    }

    public function updateInfo(Request $request)
    {
        $authUser = Auth::user();

        $request->validate([
            'name' => 'string|min:3|max:50',
            'email' => 'string|email|max:50|unique:users,email,' . $authUser->id,
        ]);

        $authUser->name = $request->name;
        $authUser->email = $request->email;
        $authUser->update();

        return redirect()->back()->with('success', 'Successful');
    }

    public function updatePassword(Request $request)
    {
        $authUser = Auth::user();

        $request->validate([
            'old_password' => 'required',
            'password' => 'required|string|min:5|confirmed',
            'password_confirmation' => 'required'
        ]);

        if (Hash::check($request->old_password, $authUser->password)) {
            $authUser->password = Hash::make($request->password);
            $authUser->update();

            return redirect()->back()->with('successPassword', 'Password updated');
        } else {
            return redirect()->back()->with('error', 'Old password does not matched');
        }
    }
}
