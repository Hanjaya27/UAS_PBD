<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    // Ambil semua pengguna
    public function index()
    {
        return response()->json(User::all());
    }

    // Tambah pengguna baru
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'email' => 'required|email|unique:user,email',
            'password' => 'required|min:6',
        ]);

        $user = User::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        return response()->json(['success' => true, 'data' => $user]);
    }

    // Update pengguna berdasarkan ID
    public function update(Request $request, $id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['success' => false, 'message' => 'User tidak ditemukan'], 404);
        }

        $request->validate([
            'nama' => 'required',
            'email' => 'required|email|unique:user,email,' . $id . ',id_user',
            'password' => 'nullable|min:6'
        ]);

        $user->nama = $request->nama;
        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }

        $user->save();

        return response()->json(['success' => true, 'data' => $user]);
    }

    // Hapus pengguna berdasarkan ID
    public function destroy($id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['success' => false, 'message' => 'User tidak ditemukan'], 404);
        }

        $user->delete();
        return response()->json(['success' => true, 'message' => 'User berhasil dihapus']);
    }

    // Cari pengguna berdasarkan email
    public function getByEmail($email)
    {
        $user = User::where('email', $email)->first();

        if (!$user) {
            return response()->json(['success' => false, 'message' => 'User tidak ditemukan'], 404);
        }

        return response()->json(['success' => true, 'data' => $user]);
    }
}
