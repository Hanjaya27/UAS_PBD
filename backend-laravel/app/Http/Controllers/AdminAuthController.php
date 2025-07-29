<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class AdminAuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        $admin = Admin::where('username', $request->username)->first();

        if ($admin && Hash::check($request->password, $admin->password)) {
            return response()->json([
                'status' => 'success',
                'message' => 'Login berhasil',
                'admin' => $admin
            ]);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Username atau password salah'
        ], 401);
    }
}
