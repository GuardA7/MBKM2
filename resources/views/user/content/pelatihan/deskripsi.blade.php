@extends('user.layouts.app')

@section('content')
<div class="container my-5">
    <h4 class="text-primary">Detail Pelatihan</h4>
    <div class="row">
        <div class="col-md-4">
            <img src="{{ asset('img/pelatihan/' . ($pelatihan->gambar ?? 'default.jpg')) }}"
                 alt="{{ $pelatihan->nama }}" class="img-fluid rounded mb-3" />

            <a href="{{ route('user.pelatihan.daftar', $pelatihan->id) }}" class="btn btn-primary w-100 mt-3">Daftar Pelatihan</a>
        </div>

        <div class="col-md-8">
            <h3>{{ $pelatihan->nama }}</h3>
            <div class="alert alert-secondary price-tag py-2 mb-3">
                Rp. {{ number_format($pelatihan->harga, 0, ',', '.') }},-
            </div>

            <p><strong>Lembaga Pelatihan</strong><br>{{ $pelatihan->lsp->nama ?? 'N/A' }}</p>
            <p><strong>Instruktur</strong><br>{{ $pelatihan->instruktur ?? 'N/A' }}</p>
            <p><strong>Sisa Kuota</strong><br>{{ $pelatihan->kuota }}</p>
        </div>
    </div>

    <div class="card mt-4 description-card">
        <div class="card-header bg-light fw-bold">
            Deskripsi
        </div>
        <div class="card-body">
            <p>{{ $pelatihan->deskripsi }}</p>
        </div>
    </div>
</div>
@endsection
