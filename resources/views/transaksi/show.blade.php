@extends('layouts.app')

@section('title', 'Detail Transaksi')

@section('content')

<div class="container">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>
            <i class="bi bi-receipt"></i>
            Detail Transaksi
        </h2>

        <a href="{{ route('transaksi.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i>
            Kembali
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    @if(
    $transaksi->status == 'Dipinjam'
    &&
    now()->gt($transaksi->tanggal_kembali)
)

<div class="alert alert-danger">

    <strong>
        <i class="bi bi-exclamation-triangle-fill"></i>
        Buku terlambat dikembalikan!
    </strong>

    <br>

    Terlambat
    <strong>
        {{ now()->diffInDays($transaksi->tanggal_kembali) }}
    </strong>
    hari.

</div>

@endif

    <div class="card">

        <div class="card-header bg-primary text-white">
            Informasi Transaksi
        </div>

        <div class="card-body">

            <table class="table">

                <tr>
                    <th width="30%">Kode Transaksi</th>
                    <td>{{ $transaksi->kode_transaksi }}</td>
                </tr>

                <tr>
                    <th>Nama Anggota</th>
                    <td>{{ $transaksi->anggota->nama }}</td>
                </tr>

                <tr>
                    <th>Buku</th>
                    <td>{{ $transaksi->buku->judul }}</td>
                </tr>

                <tr>
                    <th>Tanggal Pinjam</th>
                    <td>{{ $transaksi->tanggal_pinjam->format('d M Y') }}</td>
                </tr>

                <tr>
                    <th>Tanggal Kembali</th>
                    <td>{{ $transaksi->tanggal_kembali->format('d M Y') }}</td>
                </tr>

                <tr>
                    <th>Tanggal Dikembalikan</th>
                    <td>
                        {{ $transaksi->tanggal_dikembalikan
                            ? $transaksi->tanggal_dikembalikan->format('d M Y')
                            : '-' }}
                    </td>
                </tr>

                <tr>
                    <th>Status</th>
                    <td>
                        @if($transaksi->status == 'Dipinjam')
                            <span class="badge bg-warning text-dark">
                                Dipinjam
                            </span>
                        @else
                            <span class="badge bg-success">
                                Dikembalikan
                            </span>
                        @endif
                    </td>
                </tr>

                <tr>
                    <th>Denda</th>
                    <td>

                        @if($transaksi->denda > 0)

                            <span class="text-danger fw-bold">
                                Rp {{ number_format($transaksi->denda,0,',','.') }}
                            </span>

                        @else

                            <span class="text-success">
                                Rp 0
                            </span>

                        @endif

                    </td>
                </tr>

                <tr>
                    <th>Keterangan</th>
                    <td>{{ $transaksi->keterangan ?? '-' }}</td>
                </tr>

            </table>

        </div>

        <div class="card-footer">

            @if($transaksi->status == 'Dipinjam')

                <form action="{{ route('transaksi.kembalikan',$transaksi->id) }}"
                      method="POST">

                    @csrf
                    @method('PATCH')

                    <button class="btn btn-success"
                        onclick="return confirm('Yakin buku sudah dikembalikan?')">

                        <i class="bi bi-check-circle"></i>

                        Kembalikan Buku

                    </button>

                </form>

            @else

                <button class="btn btn-secondary" disabled>

                    Buku Sudah Dikembalikan

                </button>

            @endif

        </div>
     </div>

</div>

@endsection