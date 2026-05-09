<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;

class ProfilController extends Controller
{
    public function edit()
    {
        return Inertia::render('Profil/Edit', [
            'user' => Auth::user(),
        ]);
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|max:255',
        ]);

        Auth::user()->update($validated);

        return back()->with('success', 'Profil mis à jour.');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password'      => 'required',
            'password'              => 'required|min:8|confirmed',
        ]);

        if (!Hash::check($request->current_password, Auth::user()->password)) {
            return back()->withErrors(['current_password' => 'Mot de passe actuel incorrect.']);
        }

        Auth::user()->update([
            'password' => Hash::make($request->password),
        ]);

        return back()->with('success', 'Mot de passe mis à jour.');
    }
}
