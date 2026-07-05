@extends('layouts.app')

@section('title', 'Laporan Transaksi')

@section('content')

<div class="container">

    <h2 class="mb-4">
        <i class="bi bi-file-earmark-text"></i>
        Laporan Transaksi
    </h2>

    {{-- Filter --}}
    <div class="card mb-4">
        <div class="card-body">

            <form method="GET">

                <div class="row">

                    <div class="col-md-2">
                        <label>Dari</label>
                        <input type="date"
                               name="dari"
                               value="{{ request('dari') }}"
                               class="form-control">
                    </div>

                    <div class="col-md-2">
                        <label>Sampai</label>
                        <input type="date"
                               name="sampai"
                               value="{{ request('sampai') }}"
                               class="form-control">
                    </div>

                    <div class="col-md-2">
                        <label>Status</label>

                        <select name="status" class="form-select">
                            <option value="">Semua</option>

                            <option value="Dipinjam"
                                {{ request('status') == 'Dipinjam' ? 'selected' : '' }}>
                                Dipinjam
                            </option>

                            <option value="Dikembalikan"
                                {{ request('status') == 'Dikembalikan' ? 'selected' : '' }}>
                                Dikembalikan
                            </option>

                        </select>
                    </div>

                    <div class="col-md-2">

                        <label>Anggota</label>

                        <select name="anggota_id" class="form-select">

                            <option value="">Semua</option>

                            @foreach($anggotas as $anggota)

                                <option value="{{ $anggota->id }}"
                                    {{ request('anggota_id') == $anggota->id ? 'selected' : '' }}>

                                    {{ $anggota->nama }}

                                </option>

                            @endforeach

                        </select>

                    </div>

                    <div class="col-md-4 d-flex align-items-end gap-2">

                    <button type="submit" class="btn btn-primary flex-fill">
                        Filter
                    </button>

                        <a href="{{ route('transaksi.laporan') }}"
                        class="btn btn-secondary flex-fill">
                            Reset

                        </a>

                        <a href="{{ route('transaksi.pdf', request()->query()) }}"
                        class="btn btn-danger flex-fill">

                            Export PDF

                        </a>

                    </div>

                </div>

            </form>

        </div>
    </div>

    {{-- Tabel --}}
    <div class="card">

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-bordered table-hover">

                    <thead class="table-light">

                        <tr>

                            <th>Kode</th>
                            <th>Anggota</th>
                            <th>Buku</th>
                            <th>Tanggal Pinjam</th>
                            <th>Tanggal Kembali</th>
                            <th>Status</th>
                            <th>Denda</th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($transaksis as $transaksi)

                        <tr>

                            <td>{{ $transaksi->kode_transaksi }}</td>

                            <td>{{ $transaksi->anggota->nama }}</td>

                            <td>{{ $transaksi->buku->judul }}</td>

                            <td>
                                {{ $transaksi->tanggal_pinjam->format('d-m-Y') }}
                            </td>

                            <td>
                                {{ $transaksi->tanggal_kembali->format('d-m-Y') }}
                            </td>

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

                            <td>

                                Rp {{ number_format($transaksi->denda,0,',','.') }}

                            </td>

                        </tr>

                        @empty

                        <tr>

                            <td colspan="7" class="text-center text-muted">

                                Tidak ada data transaksi

                            </td>

                        </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

            <hr>

            <div class="row">

                <div class="col-md-6">

                    <h5>

                        Total Transaksi :
                        <strong>{{ $transaksis->count() }}</strong>

                    </h5>

                </div>

                <div class="col-md-6 text-end">

                    <h5>

                        Total Denda :
                        <strong>

                            Rp {{ number_format($totalDenda,0,',','.') }}

                        </strong>

                    </h5>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection