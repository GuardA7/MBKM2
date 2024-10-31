@extends('user.layouts.app')

@section('content')
<div class="container my-5">
    <h2 class="form-title text-center">Pendaftaran Pelatihan</h2>
    <div class="card mt-4">
        <div class="card-body">
            <form>
                <!-- Nama Lengkap -->
                <div class="mb-3">
                    <label for="namaLengkap" class="form-label">Nama Lengkap</label>
                    <input type="text" class="form-control" id="namaLengkap" value="Dewi Ramdani" required>
                </div>

                <!-- NIM -->
                <div class="mb-3">
                    <label for="nim" class="form-label">NIM</label>
                    <input type="text" class="form-control" id="nim" value="908899" required>
                </div>

                <!-- No. Telp -->
                <div class="mb-3">
                    <label for="noTelp" class="form-label">No. Telp</label>
                    <input type="text" class="form-control" id="noTelp" value="77676687587587" required>
                </div>

                <!-- Email -->
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" value="dera@gmail.com" required>
                </div>

                <!-- Bukti Pembayaran -->
                <div class="mb-3">
                    <label for="buktiPembayaran" class="form-label">Bukti Pembayaran</label>
                    <input type="file" class="form-control" id="buktiPembayaran" required>
                    <small class="form-text text-muted">JPG, PNG MAX: 2MB</small>
                </div>

                <!-- Tombol Aksi -->
                <div class="d-flex justify-content-between">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <button type="button" class="btn btn-danger" onclick="window.location.href='{{ route('pelatihan.deskripsi') }}'">Batal</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
