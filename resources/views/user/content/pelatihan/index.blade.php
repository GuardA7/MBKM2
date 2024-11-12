@extends('user.layouts.app') <!-- Assuming there's a user layout file -->

@section('content')
<div class="container">
    <h1 class="my-4">Pelatihan yang Tersedia</h1>
    <div class="row">
        @forelse($pelatihans as $pelatihan)
            <div class="col-md-4 mb-4">
                <div class="card">
                    <img src="{{ asset('img/pelatihan/' . ($pelatihan->gambar ?? 'default.jpg')) }}" class="card-img-top" alt="{{ $pelatihan->nama }}">
                    <div class="card-body">
                        <h5 class="card-title">{{ $pelatihan->nama }}</h5>
                        <p class="card-text">{{ Str::limit($pelatihan->deskripsi, 100) }}</p>
                        <p class="card-text"><strong>Harga:</strong> Rp. {{ number_format($pelatihan->harga, 0, ',', '.') }}</p>
                        <p class="card-text"><strong>Kuota:</strong> {{ $pelatihan->kuota }}</p>
                        <a href="{{ route('user.pelatihan.deskripsi', $pelatihan->id) }}" class="btn btn-primary">Lihat Detail</a>
                    </div>
                </div>
            </div>
        @empty
            <p class="text-center">Tidak ada pelatihan yang tersedia.</p>
        @endforelse
    </div>

    <!-- Pagination Links -->

</div>
@endsection
