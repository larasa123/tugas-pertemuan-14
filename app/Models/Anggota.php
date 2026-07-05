<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Anggota extends Model
{
    use HasFactory;

    protected $table = 'anggota';

    protected $fillable = [
        'kode_anggota',
        'nama',
        'email',
        'telepon',
        'alamat',
        'tanggal_lahir',
        'jenis_kelamin',
        'pekerjaan',
        'tanggal_daftar',
        'status',
    ];

    // =====================
    // ACCESSOR
    // =====================

    public function getUmurAttribute()
    {
        if (!$this->tanggal_lahir) return 0;

        return Carbon::parse($this->tanggal_lahir)->age;
    }

    public function getStatusBadgeAttribute()
    {
        return strtolower($this->status) === 'aktif'
            ? '<span class="badge bg-success">Aktif</span>'
            : '<span class="badge bg-secondary">Nonaktif</span>';
    }

    public function getKategoriUsiaAttribute()
    {
        if ($this->umur < 20) {
            return 'Remaja';
        } elseif ($this->umur <= 50) {
            return 'Dewasa';
        } else {
            return 'Senior';
        }
    }

    // =====================
    // SCOPE
    // =====================

    public function scopeJenisKelamin($query, $jk)
    {
        return $query->where('jenis_kelamin', $jk);
    }

    public function scopeTerdaftarBulanIni($query)
    {
        return $query->whereMonth('tanggal_daftar', now()->month)
                     ->whereYear('tanggal_daftar', now()->year);
    }

    public function transaksis()
    {
    return $this->hasMany(Transaksi::class);
    }
}