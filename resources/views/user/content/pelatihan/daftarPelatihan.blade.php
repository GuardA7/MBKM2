@extends('user.layouts.app')

@section('content')
<div class="container my-5">
    <h2 class="text-center">Pendaftaran Pelatihan</h2>
    <div class="card mt-4">
        <div class="card-body">
            <h4>{{ $pelatihan->nama }}</h4>
            <p><strong>Lembaga Pelatihan:</strong> {{ $pelatihan->lsp->nama ?? 'N/A' }}</p>
            <p><strong>Harga:</strong> Rp. {{ number_format($pelatihan->harga, 0, ',', '.') }}</p>
        </div>
    </div>

    <form action="{{ route('user.pelatihan.daftar.submit', $pelatihan->id) }}" method="POST" enctype="multipart/form-data" class="mt-4">
        @csrf

        <!-- Nama User (read-only) -->
        <div class="mb-3">
            <label for="nama_user" class="form-label">Nama User</label>
            <input type="text" class="form-control" id="nama_user" name="nama_user" value="{{ auth()->user()->nama }}" readonly>
        </div>

        <!-- Email (read-only) -->
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="{{ auth()->user()->email }}" readonly>
        </div>

        <!-- No Telepon -->
        <div class="mb-3">
            <label for="no_telp" class="form-label">No. Telepon</label>
            <input type="text" class="form-control" id="no_telp" name="no_telp" value="{{ old('no_hp', auth()->user()->no_hp) }}" required>
        </div>

        <!-- Bukti Pembayaran -->
        <div class="mb-3">
            <label for="bukti_pembayaran" class="form-label">Upload Bukti Pembayaran</label>
            <input type="file" class="form-control" id="bukti_pembayaran" name="bukti_pembayaran" required>
            @error('bukti_pembayaran')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary w-100">Daftar Pelatihan</button>
    </form>
</div>
@endsection
