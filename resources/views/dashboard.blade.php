@extends('layouts.app')

@section('title','Dashboard')

@section('content')

<div class="container">

    <h2 class="mb-4">
        Dashboard
    </h2>

    {{-- Widget Dashboard --}}
    <div class="row mb-4">

        {{-- Buku Terlambat --}}
        <div class="col-md-6">

            <div class="card border-danger shadow-sm h-100">

                <div class="card-body text-center">

                    <h4 class="text-danger">
                        <i class="bi bi-exclamation-triangle-fill"></i>
                        Buku Terlambat
                    </h4>

                    <h1 class="display-4 fw-bold text-danger">
                        {{ $terlambat->count() }}
                    </h1>

                    <p class="mb-0 text-muted">
                        Transaksi Terlambat
                    </p>

                </div>

            </div>

        </div>

        {{-- Transaksi Terlambat --}}
        <div class="col-md-6">

            <div class="card border-warning shadow-sm h-100">

                <div class="card-body text-center">

                    <h4 class="text-warning">
                        <i class="bi bi-clock-history"></i>
                        Transaksi Terlambat
                    </h4>

                    <h1 class="display-4 fw-bold text-warning">
                        {{ $terlambat->count() }}
                    </h1>

                    <p class="mb-0 text-muted">
                        Belum Dikembalikan
                    </p>

                </div>

            </div>

        </div>

    </div>

    {{-- Daftar Anggota Terlambat --}}
    <div class="card shadow-sm">

        <div class="card-header bg-danger text-white">

            <i class="bi bi-person-exclamation"></i>
            Daftar Anggota Terlambat

        </div>

        <div class="card-body">

            @forelse($terlambat as $transaksi)

                <div class="border rounded p-3 mb-3">

                    <h5 class="mb-2">
                        👤 {{ $transaksi->anggota->nama }}
                    </h5>

                    <p class="mb-1">
                        📚 <strong>{{ $transaksi->buku->judul }}</strong>
                    </p>

                    <p class="mb-0 text-danger fw-bold">
                        ⏰ Terlambat
                        {{ now()->diffInDays($transaksi->tanggal_kembali) }}
                        hari
                    </p>

                </div>

            @empty

                <div class="alert alert-success mb-0">

                    <i class="bi bi-check-circle-fill"></i>
                    Tidak ada buku yang terlambat.

                </div>

            @endforelse

        </div>

    </div>

</div>

@endsection