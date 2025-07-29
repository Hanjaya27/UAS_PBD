<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    // Ambil semua admin
    public function index()
    {
        return response()->json(Admin::all());
    }

    // Tambah admin baru
    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|unique:admin',
            'password' => 'required|min:6'
        ]);

        $admin = Admin::create([
            'username' => $request->username,
            'password' => Hash::make($request->password)
        ]);

        return response()->json(['message' => 'Admin berhasil ditambahkan', 'admin' => $admin]);
    }

    // Update admin
    public function update(Request $request, $id)
{
    $admin = Admin::findOrFail($id);

    $request->validate([
        'username' => 'required|unique:admin,username,' . $id . ',id_admin',
        'password' => 'nullable|min:6'
    ]);

    $admin->username = $request->username;
    if ($request->password) {
        $admin->password = Hash::make($request->password);
    }
    $admin->save();

    return response()->json(['message' => 'Admin berhasil diperbarui', 'admin' => $admin]);
}


    // Hapus admin
    public function destroy($id)
    {
        $admin = Admin::findOrFail($id);
        $admin->delete();

        return response()->json(['message' => 'Admin berhasil dihapus']);
    }
}
