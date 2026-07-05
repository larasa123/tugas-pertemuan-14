<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{
    use HasFactory;

    protected $table = 'buku';

    protected $fillable = [
        'kode_buku',
        'judul',
        'kategori',
        'pengarang',
        'penerbit',
        'tahun_terbit',
        'isbn',
        'harga',
        'stok',
        'deskripsi',
        'bahasa',
    ];

    // =====================
    // ACCESSOR
    // =====================

    public function getStatusStokBadgeAttribute()
    {
        if ($this->stok == 0) {
            return '<span class="badge bg-danger">Habis</span>';
        } elseif ($this->stok <= 5) {
            return '<span class="badge bg-warning">Menipis</span>';
        } elseif ($this->stok <= 15) {
            return '<span class="badge bg-info">Sedang</span>';
        } else {
            return '<span class="badge bg-success">Aman</span>';
        }
    }

    public function getTahunLabelAttribute()
    {
        return $this->tahun_terbit >= 2024 ? 'Buku Baru' : 'Buku Lama';
    }

    // =====================
    // SCOPE
    // =====================

    public function scopeStokMenipis($query)
    {
        return $query->where('stok', '<', 5);
    }

    public function scopeHargaRange($query, $min, $max)
    {
        return $query->whereBetween('harga', [$min, $max]);
    }

    public function scopeTerbaru($query)
    {
        return $query->where('tahun_terbit', '>=', 2024);
    }

    public function transaksis()
    {
    return $this->hasMany(Transaksi::class);
    }
}