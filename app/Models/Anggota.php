<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Anggota extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_anggota',
        'nama',
        'jenis_kelamin',
        'tempat_lahir',
        'tanggal_lahir',
        'telepon',
        'alamat',
        'foto',
    ];

    public function peminjaman()
    {
        return $this->hasMany(Peminjaman::class, 'anggota_id');
    }
}