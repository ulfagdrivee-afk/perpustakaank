<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peminjaman_detail extends Model
{
      use HasFactory;

    protected $fillable = [
        'peminjaman_id',
        'buku_id',
        'jumlah',
    ];

    public function peminjaman()
    {
        return $this->belongsTo(Peminjaman::class, 'peminjaman_id');
    }
    public function buku()
    {
        return $this->anggota(Buku::class, 'buku_id');
    }
}
