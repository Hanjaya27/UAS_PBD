<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PembayaranController extends Controller
{
    // Ambil semua data pembayaran dengan relasi ke pemesanan
    public function index()
    {
        $data = Pembayaran::with('pemesanan')->get();

        return response()->json([
            'status' => 'success',
            'data' => $data
        ]);
    }

    public function store(Request $request)
    {
        \Log::info('Isi request pembayaran:', $request->all());

        $request->validate([
            'id_pemesanan' => 'required|integer|exists:pemesanan,id_pemesanan',
            'tgl_bayar' => 'required|date',
            'bukti_bayar' => 'required|file|image|max:2048', // maks. 2MB dan harus gambar
            'jml_bayar' => 'required|numeric',
            'metode' => 'required|string',
            'bukti_bayar' => $request->metode === 'Tunai' ? 'nullable' : 'required|file|image|max:2048',
        ]);

        if ($request->metode === 'Tunai') {
            $nama_file = 'tunai.png'; // nama file default yang sudah ada di public/
        } else {
            $file = $request->file('bukti_bayar');
            if ($file) {
                $nama_file = time().'_'.$file->getClientOriginalName();
                $file->move(public_path('bukti_bayar'), $nama_file);
            } else {
                return response()->json(['error' => 'Bukti bayar wajib diupload jika metode bukan Tunai.'], 400);
            }
        }

        $pembayaran = Pembayaran::create([
            'id_pemesanan' => $request->id_pemesanan,
            'tgl_bayar' => $request->tgl_bayar,
            'jml_bayar' => $request->jml_bayar,
            'metode' => $request->metode,
            'bukti_bayar' => $nama_file,
            'status' => 'belum lunas' // ✅ inilah perbaikannya
        ]);


        return response()->json(['message' => 'Pembayaran berhasil disimpan', 'data' => $pembayaran], 201);
    }


    // Update status pembayaran
    public function updateStatus(Request $request)
    {
        $request->validate([
            'id_pembayaran' => 'required|integer|exists:pembayaran,id_pembayaran',
            'status_pembayaran' => 'required|string'
        ]);

        $pembayaran = Pembayaran::find($request->id_pembayaran);

        if (!$pembayaran) {
            return response()->json([
                'status' => 'error',
                'message' => 'Pembayaran tidak ditemukan.'
            ], 404);
        }

        $pembayaran->status = $request->status_pembayaran;
        $pembayaran->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Status pembayaran berhasil diperbarui.',
            'data' => $pembayaran
        ]);
    }

    // Tampilkan bukti bayar berupa file gambar
    public function buktiBayar($filename)
    {
        $filePath = 'public/bukti_bayar/' . $filename;

        if (!Storage::exists($filePath)) {
            return response()->json([
                'status' => 'error',
                'message' => 'File tidak ditemukan.'
            ], 404);
        }

        return response()->file(storage_path('app/' . $filePath));
    }
}
