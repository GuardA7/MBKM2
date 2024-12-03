@extends('user.layouts.app')

@section('content')
<div class="container mt-5">
    <div class="card shadow-lg p-4">
        <div class="card-body">
            <!-- Judul Halaman -->
            <h1 class="text-center text-primary mb-4">Detail Pelatihan</h1>

            <!-- Gambar dan Informasi Utama -->
            <div class="row align-items-center">
                <!-- Gambar Pelatihan -->
                <div class="col-md-5 text-center mb-3">
                    <img src="{{ asset('img/pelatihan/' . ($pelatihan->gambar ?? 'default.jpg')) }}"
                         class="img-fluid rounded shadow-sm"
                         alt="Gambar Pelatihan"
                         style="max-width: 100%; object-fit: cover;">
                </div>

                <!-- Judul dan Harga -->
                <div class="col-md-7">
                    <h2 class="card-title text-primary fw-bold">{{ $pelatihan->nama }}</h2>
                    <h4 class="text-success fw-bold">Rp {{ number_format($pelatihan->harga, 0, ',', '.') }}</h4>
                    <p class="text-muted mt-2"><em>"{{ $pelatihan->deskripsi }}"</em></p>
                </div>
            </div>

            <!-- Detail Tambahan -->
            <div class="mt-4">
                <h4 class="text-primary">Informasi Pelatihan</h4>
                <hr>
                <p class="card-text"><strong>Jenis:</strong> {{ $pelatihan->jenis_pelatihan }}</p>
                <p class="card-text"><strong>Durasi:</strong> {{ $pelatihan->durasi }} jam</p>
                <p class="card-text"><strong>Lokasi:</strong> {{ $pelatihan->lokasi }}</p>
                <p class="card-text"><strong>Status Pendaftaran:</strong>
                    <span class="badge {{ $pelatihan->pivot->status_pendaftaran == 'diterima' ? 'bg-success' : 'bg-warning' }}">
                        {{ ucfirst($pelatihan->pivot->status_pendaftaran) }}
                    </span>
                </p>
            </div>

            <!-- Tombol Kembali -->
            <div class="text-center mt-5">
                <a href="{{ route('pelatihan.saya') }}" class="btn btn-primary btn-lg shadow-sm">
                    <i class="fas fa-arrow-left me-2"></i> Kembali ke Daftar Pelatihan
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
