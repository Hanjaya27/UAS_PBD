<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pemesanan;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class PemesananSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        // Ambil semua ID user dan kendaraan yang ada di database
        $userIds = DB::table('user')->pluck('id_user')->toArray();
        $kendaraanIds = DB::table('kendaraan')->pluck('id_kendaraan')->toArray();

        // Jika salah satu kosong, hentikan proses
        if (empty($userIds) || empty($kendaraanIds)) {
            echo "Data user atau kendaraan kosong. Tambahkan data parent terlebih dahulu.\n";
            return;
        }

        for ($i = 0; $i < 1000; $i++) {
            Pemesanan::create([
                'id_user' => $faker->randomElement($userIds), // pilih ID yang benar-benar ada
                'id_kendaraan' => $faker->randomElement($kendaraanIds), // pilih ID yang benar-benar ada
                'tgl_mulai' => $faker->date(),
                'tgl_selesai' => $faker->date(),
                'total_harga' => $faker->numberBetween(100000, 2000000),
                'status' => $faker->randomElement(['diproses', 'selesai', 'batal']),
            ]);
        }
    }
}
