<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Laporan Transaksi</title>

    <style>

        body{
            font-family: DejaVu Sans, sans-serif;
            font-size:12px;
        }

        h2{
            text-align:center;
            margin-bottom:20px;
        }

        table{
            width:100%;
            border-collapse:collapse;
        }

        table,th,td{
            border:1px solid #000;
        }

        th,td{
            padding:8px;
            text-align:left;
        }

        th{
            background:#eeeeee;
        }

        .footer{
            margin-top:20px;
            font-weight:bold;
        }

    </style>

</head>

<body>

<h2>LAPORAN TRANSAKSI PERPUSTAKAAN</h2>

<table>

    <thead>

    <tr>

        <th>No</th>
        <th>Kode</th>
        <th>Anggota</th>
        <th>Buku</th>
        <th>Tgl Pinjam</th>
        <th>Status</th>
        <th>Denda</th>

    </tr>

    </thead>

    <tbody>

    @forelse($transaksis as $transaksi)

    <tr>

        <td>{{ $loop->iteration }}</td>

        <td>{{ $transaksi->kode_transaksi }}</td>

        <td>{{ $transaksi->anggota->nama }}</td>

        <td>{{ $transaksi->buku->judul }}</td>

        <td>{{ $transaksi->tanggal_pinjam->format('d-m-Y') }}</td>

        <td>{{ $transaksi->status }}</td>

        <td>

            Rp {{ number_format($transaksi->denda,0,',','.') }}

        </td>

    </tr>

    @empty

    <tr>

        <td colspan="7" align="center">

            Tidak ada data

        </td>

    </tr>

    @endforelse

    </tbody>

</table>

<div class="footer">

    Total Transaksi :
    {{ $transaksis->count() }}

    <br><br>

    Total Denda :
    Rp {{ number_format($totalDenda,0,',','.') }}

</div>

</body>

</html>