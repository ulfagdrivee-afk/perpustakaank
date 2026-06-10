<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengembalian extends Model
{
      use HasFactory;

    protected $fillable = [
        'peminjaman_id',
        'tanggal_kembali',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function peminjaman()
    {
        return $this->anggota(Peminjaman::class, 'peminjaman_id');
    }
}
