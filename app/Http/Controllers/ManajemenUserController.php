<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ManajemenUserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('manajemenuser', compact('users'));
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('edituser', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'password' => 'required|min:6|confirmed',
        ]);

        $user = User::findOrFail($id);
        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->route('manajemenuser.index')->with('success', 'Password berhasil diubah.');
    }
}
