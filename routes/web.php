<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\AnggotaController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TransaksiController;

// Public routes
Route::get('/', function () {
    return redirect()->route('login');
});

// Protected routes
Route::middleware(['auth'])->group(function () {

    // Dashboard
   Route::get('/dashboard', [TransaksiController::class, 'dashboard'])
    ->name('dashboard');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Buku
   
    // Filter kategori
    Route::get('/buku/kategori/{kategori}', [BukuController::class, 'filterKategori'])
        ->name('buku.kategori');

    // Search
    Route::get('/buku/search', [BukuController::class, 'search'])
        ->name('buku.search');

    // Bulk Delete
    Route::post('/buku/bulk-delete', [BukuController::class, 'bulkDelete'])
        ->name('buku.bulk-delete');

    // Export CSV
    Route::get('/buku/export', [BukuController::class, 'export'])
        ->name('buku.export');   
    Route::resource('buku', BukuController::class);   

    // Anggota
   
    // Search Anggota
    Route::get('/anggota/search', [AnggotaController::class, 'search'])
        ->name('anggota.search');

    // Export Anggota
    Route::get('/anggota/export', [AnggotaController::class, 'export'])
        ->name('anggota.export');
    Route::resource('anggota', AnggotaController::class);

    // transaksi
    
    Route::get('/transaksi/laporan', [TransaksiController::class, 'laporan'])
    ->name('transaksi.laporan');

    Route::get('/transaksi/laporan/pdf', [TransaksiController::class, 'exportPdf'])
    ->name('transaksi.pdf');

    Route::patch('/transaksi/{id}/kembalikan',
        [TransaksiController::class, 'kembalikan'])
        ->name('transaksi.kembalikan');
    Route::resource('transaksi', TransaksiController::class);

});

require __DIR__.'/auth.php';