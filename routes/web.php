<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\PerpustakaanController;
use App\Http\Controllers\KategoriController;
use App\Models\Buku;
use App\Models\Anggota;
use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\BukuController;


// Route default
Route::get('/', function () {
    return view('home');
})->name('home');

Route::resource('buku', BukuController::class);

Route::get('/buku/kategori/{kategori}', [BukuController::class, 'filterKategori'])
     ->name('buku.kategori');

Route::resource('anggota', AnggotaController::class);

// Route hello
Route::get('/hello', function () {
    return 'Hello dari Laravel!';
});

// Route info
Route::get('/info', function () {
    return '<h1>Sistem Perpustakaan</h1><p>Selamat datang!</p>';
});

// Route dengan multiple parameters
Route::get('/search/{kategori}/{keyword}', function ($kategori, $keyword) {
    return "Cari buku kategori: $kategori dengan keyword: $keyword";
});

Route::get('/perpustakaan', [PerpustakaanController::class, 'index']);


Route::get('/kategori', [KategoriController::class, 'index']);
Route::get('/kategori/search/{keyword}', [KategoriController::class, 'search']);
Route::get('/kategori/{id}', [KategoriController::class, 'show']);

// Route test koneksi database
Route::get('/test-db', function () {
    try {
        // use DB facade helpers to avoid static analysis error for getPdo()/getDatabaseName()
        DB::getPdo();
        $dbName = DB::getDatabaseName();

        return "Koneksi database berhasil!<br />Database: <strong>{$dbName}</strong>";
    } catch (\Exception $e) {
        return "Koneksi database gagal!<br />Error: " . $e->getMessage();
    }
});
Route::get('/test-accessor-scope', function () {

    $html = '<h1>Testing Accessor & Scope</h1>';

    // ================= BUKU =================
    $html .= '<h2>Buku</h2>';
    $html .= '<table border="1" cellpadding="5">
                <tr>
                    <th>Judul</th>
                    <th>Stok</th>
                    <th>Status</th>
                </tr>';

    foreach (Buku::all() as $b) {
        $html .= '<tr>
                    <td>'.$b->judul.'</td>
                    <td>'.$b->stok.'</td>
                    <td>'.strip_tags($b->status_stok_badge).'</td>
                  </tr>';
    }

    $html .= '</table>';

    // ================= BUKU TERBARU =================
    $html .= '<h2>Buku Terbaru</h2>';
    $html .= '<table border="1" cellpadding="5">
                <tr><th>Judul</th></tr>';

    foreach (Buku::terbaru()->get() as $b) {
        $html .= '<tr><td>'.$b->judul.'</td></tr>';
    }

    $html .= '</table>';

    // ================= BUKU STOK MENIPIS =================
    $html .= '<h2>Buku Stok Menipis</h2>';
    $html .= '<table border="1" cellpadding="5">
                <tr>
                    <th>Judul</th>
                    <th>Stok</th>
                </tr>';

    foreach (Buku::stokMenipis()->get() as $b) {
        $html .= '<tr>
                    <td>'.$b->judul.'</td>
                    <td>'.$b->stok.'</td>
                  </tr>';
    }

    $html .= '</table>';

    // ================= ANGGOTA =================
    $html .= '<h2>Anggota</h2>';
    $html .= '<table border="1" cellpadding="5">
                <tr>
                    <th>Nama</th>
                    <th>Status</th>
                    <th>Kategori Usia</th>
                </tr>';

    foreach (Anggota::all() as $a) {
        $html .= '<tr>
                    <td>'.$a->nama.'</td>
                    <td>'.strip_tags($a->status_badge).'</td>
                    <td>'.$a->kategori_usia.'</td>
                  </tr>';
    }

    $html .= '</table>';

    // ================= BULAN INI =================
    $html .= '<h2>Anggota Bulan Ini</h2>';
    $html .= '<table border="1" cellpadding="5">
                <tr><th>Nama</th></tr>';

    foreach (Anggota::terdaftarBulanIni()->get() as $a) {
        $html .= '<tr><td>'.$a->nama.'</td></tr>';
    }

    $html .= '</table>';

    return $html;
});