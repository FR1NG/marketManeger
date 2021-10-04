<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    public function updateInfo(Request $request)
    {
        $request->validate([
            "name" => 'required|min:3|max:60',
            'email' => 'required|email|unique:users,email,' . Auth::id(),
        ]);

        $user = Auth::user();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->update();
        return response()->json(['message' => 'Les informations de l\'utilisateur ont été mises à jour avec succès']);
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'old' => 'required',
            'new' => 'required|confirmed|min:8|max:100',
        ]);

        $user = Auth::user();
        if (Hash::check($request->old, $user->password)) {
            $user->fill([
                'password' => Hash::make($request->new)
            ])->save();
        } else {
            throw ValidationException::withMessages(['old' => 'Le mot de passe est incorrect']);
        }
        return response()->json(['message' => 'Le mot de passe a été mis à jour avec succès']);
    }
}
