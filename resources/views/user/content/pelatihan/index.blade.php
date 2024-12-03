@extends('user.layouts.app')

@section('content')
<div class="container my-4">
    <!-- Search Bar -->
    <div class="row mb-3">
        <div class="col-md-12">
            <form action="{{ route('user.pelatihan.index') }}" method="GET" class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Cari pelatihan..." value="{{ request('search') }}">
                <button type="submit" class="btn btn-primary">Cari</button>
            </form>
        </div>
    </div>

    <!-- Category Filter Buttons -->
    <div class="row mb-4">
        <div class="col-md-12">
            <h5 class="mb-3">Kategori Pelatihan</h5>
            <div class="row">
                <!-- All Categories Button -->
                <div class="col-6 col-sm-4 col-md-3 col-lg-2 mb-3">
                    <a href="{{ route('user.pelatihan.index') }}" class="btn btn-primary w-100 h-100 d-flex flex-column justify-content-center align-items-center">
                        <span class="font-weight-bold">Semua Kategori</span>
                    </a>
                </div>

                <!-- Category Buttons -->
                @foreach($kategoris as $kategori)
                    <div class="col-6 col-sm-4 col-md-3 col-lg-2 mb-3">
                        <a href="{{ route('user.pelatihan.index', ['category' => $kategori->id]) }}" class="btn btn-primary w-100 h-100 d-flex flex-column justify-content-center align-items-center {{ request('category') == $kategori->id ? 'active' : '' }}">
                            <span class="font-weight-bold">{{ $kategori->nama }}</span>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Pelatihan Cards -->
    <div class="row">
        @forelse($pelatihans as $pelatihan)
            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow-sm">
                    <img src="{{ asset('img/pelatihan/' . ($pelatihan->gambar ?? 'default.jpg')) }}" class="card-img-top" alt="{{ $pelatihan->nama }}">
                    <div class="card-body">
                        <h5 class="card-title">{{ $pelatihan->nama }}</h5>
                        <p class="card-text text-success fw-bold fs-5 mb-2"><strong>Harga:</strong> Rp. {{ number_format($pelatihan->harga, 0, ',', '.') }}</p>
                        <p class="card-text ">{{ Str::limit($pelatihan->deskripsi, 100) }}</p>

                        <a href="{{ route('user.pelatihan.deskripsi', $pelatihan->id) }}" class="btn btn-primary">Lihat Detail</a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <p class="text-center">Tidak ada pelatihan yang ditemukan untuk kategori ini.</p>
            </div>
        @endforelse
    </div>

    <!-- Pagination Links -->
    <div class="d-flex justify-content-center mt-4">
        {{ $pelatihans->links() }}
    </div>
</div>
@endsection
