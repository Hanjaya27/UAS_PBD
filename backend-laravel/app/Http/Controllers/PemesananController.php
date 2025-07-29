<?php

namespace App\Http\Controllers;

use App\Models\Pemesanan;
use Illuminate\Http\Request;

class PemesananController extends Controller
{
    public function index()
    {
        $data = Pemesanan::with(['user', 'kendaraan'])->get();
        return response()->json($data);
    }

    public function show($id)
    {
        $pemesanan = Pemesanan::with(['kendaraan', 'pembayaran'])->find($id);

        if (!$pemesanan) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data pemesanan tidak ditemukan.'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $pemesanan
        ]);
    }

    public function simpan(Request $request)
    {
        $validated = $request->validate([
            'id_user' => 'required|integer',
            'id_kendaraan' => 'required|integer',
            'tgl_mulai' => 'required|date',
            'tgl_selesai' => 'required|date',
            'total_harga' => 'required|numeric'
        ]);

        $validated['status'] = 'diproses';

        $pemesanan = Pemesanan::create($validated);

        return response()->json([
            'status' => $pemesanan ? 'success' : 'error',
            'id_pemesanan' => $pemesanan->id_pemesanan
        ]);
    }

    public function riwayat($id_user)
    {
        $riwayat = Pemesanan::with('kendaraan')
            ->where('id_user', $id_user)
            ->get();

        return response()->json(['status' => true, 'data' => $riwayat]);
    }

    public function getById($id_pemesanan)
    {
        $pemesanan = Pemesanan::find($id_pemesanan);
        if ($pemesanan) {
            return response()->json(['status' => true, 'data' => $pemesanan]);
        } else {
            return response()->json(['status' => false, 'message' => 'Pemesanan tidak ditemukan.']);
        }
    }

    public function updateStatus(Request $request)
    {
        $id = $request->input('id_pemesanan');
        $status = $request->input('status');

        $updated = Pemesanan::where('id_pemesanan', $id)->update(['status' => $status]);

        return response()->json(['success' => $updated]);
    }
}
