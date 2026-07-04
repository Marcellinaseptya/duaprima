<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::orderBy('nama')->paginate(10);
        return view('users', compact('users'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'email' => 'required|email|unique:users',
            'role' => 'required|in:admin,manajer,sopir,owner', 
            'password' => 'required|min:6',
        ]);

        User::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'role' => $request->role,
            // LANGSUNG MASUKKAN PASSWORD POLOS, Model yang akan melakukan hashing
            'password' => $request->password, 
        ]);

        return redirect()->route('users.index')->with('success', 'Pengguna ditambahkan.');
    }

    public function edit(User $user)
    {
        return view('users.edit', compact('user')); 
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'nama' => 'required',
            'email' => "required|email|unique:users,email,$user->id",
            'role' => 'required|in:admin,manajer,sopir,owner', 
            'password' => 'nullable|min:6',
        ]);

        $data = $request->only(['nama', 'email', 'role']);
        
        if ($request->filled('password')) {
            // LANGSUNG MASUKKAN PASSWORD POLOS
            $data['password'] = $request->password; 
        }

        $user->update($data);

        return redirect()->route('users.index')->with('success', 'Pengguna diperbarui.');
    }

    public function destroy(User $user)
    {
        $user->delete();
        
        return redirect()->route('users.index')->with('success', 'Pengguna dihapus.');
    }
}