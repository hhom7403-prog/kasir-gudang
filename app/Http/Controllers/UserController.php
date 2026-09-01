<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        $users = User::orderBy('name')->paginate(20);

        return view('users.index', compact('users'));
    }

    public function update(Request $request, User $user)
    {
        $data = $request->validate(['role' => ['required', 'in:'.implode(',', User::ROLES)]]);

        if ($user->is(Auth::user()) && $data['role'] !== 'admin') {
            return back()->withErrors(['role' => 'Admin tidak boleh menurunkan role akunnya sendiri.']);
        }

        $user->update($data);

        return back()->with('success', 'Role pengguna berhasil diperbarui.');
    }
}
