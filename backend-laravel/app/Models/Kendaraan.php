<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kendaraan extends Model
{
    protected $table = 'kendaraan';
    protected $primaryKey = 'id_kendaraan';
    public $timestamps = false;

    protected $fillable = [
        'tipe', 'jenis', 'plat_nomor', 'harga_perhari', 'gambar', 'status'
    ];
}
