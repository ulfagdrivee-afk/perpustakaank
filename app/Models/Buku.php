<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{
      use HasFactory;

    protected $fillable = [
        'kode_buku',
        'judul',
        'kategori_id',
        'penerbit_id',
        'isbn',
        'pengarang',
        'jumlah_halaman',
        'jumlah_stok',
        'tahun_terbit',
        'sinopsis',
        'gambar',
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }
    public function penerbit()
    {
        return $this->anggota(Penerbit::class, 'penerbit_id');
    }
}
