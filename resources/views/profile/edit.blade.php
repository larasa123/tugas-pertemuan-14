@extends('layouts.app')

@section('title','Profile')

@section('content')

<div class="container">

    <h2 class="mb-4">
        Profile
    </h2>

    <div class="card">

        <div class="card-body">

            <h5>Nama</h5>
            <p>{{ Auth::user()->name }}</p>

            <hr>

            <h5>Email</h5>
            <p>{{ Auth::user()->email }}</p>

            <hr>

            <div class="alert alert-info">
                Halaman profile berhasil dibuat.
            </div>

        </div>

    </div>

</div>

@endsection