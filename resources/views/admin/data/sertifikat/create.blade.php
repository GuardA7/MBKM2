@extends('admin.layouts.app')

@section('title', 'Tambah Sertifikat Pengguna')

@section('content')
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Tambah Sertifikat Pengguna</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="/" class="text-decoration-none">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.sertifikat.index') }}"
                        class="text-decoration-none">Sertifikat</a></li>
                <li class="breadcrumb-item active">Tambah Sertifikat</li>
            </ol>

            <!-- form create -->
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h5><i class="fas fa-plus-circle"></i> Tambah Sertifikat</h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.sertifikat.store', $user->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf

                                <!-- User id -->
                                <div class="mb-3">
                                    <input type="hidden" name="user_id" value="{{ $user->id }}">
                                </div>

                                <!-- User Role -->
                                <div class="mb-3">
                                    <input type="hidden" class="form-control" id="user_role"
                                        value="{{ ucfirst($user->role) }}" readonly>
                                </div>

                                <!-- Nama Pelatihan -->
                                <div class="mb-3">
                                    <label for="nama_pelatihan" class="form-label">Nama Pelatihan</label>
                                    <input type="text" class="form-control @error('nama_pelatihan') is-invalid @enderror"
                                        name="nama_pelatihan" id="nama_pelatihan" value="{{ old('nama_pelatihan') }}" placeholder="Masukkan Nama Pelatihan"
                                        required>
                                    @error('nama_pelatihan')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Tanggal Berlaku -->
                                <div class="mb-3">
                                    <label for="tanggal_berlaku" class="form-label">Tanggal Berlaku</label>
                                    <input type="date"
                                        class="form-control @error('tanggal_berlaku') is-invalid @enderror"
                                        name="tanggal_berlaku" id="tanggal_berlaku" value="{{ old('tanggal_berlaku') }}">
                                    @error('tanggal_berlaku')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Tanggal Berakhir -->
                                <div class="mb-3">
                                    <label for="tanggal_berakhir" class="form-label">Tanggal Berakhir</label>
                                    <input type="date"
                                        class="form-control @error('tanggal_berakhir') is-invalid @enderror"
                                        name="tanggal_berakhir" id="tanggal_berakhir" value="{{ old('tanggal_berakhir') }}">
                                    @error('tanggal_berakhir')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- File Sertifikat -->
                                <div class="mb-3">
                                    <label for="sertifikat_file" class="form-label">File Sertifikat</label>
                                    <input type="file" class="form-control" name="sertifikat_file" id="sertifikat_file">
                                    @error('sertifikat_file')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="d-flex justify-content-start">
                                    <button type="submit" class="btn btn-sm btn-primary"><i class="fas fa-save"></i>
                                        Tambah</button>
                                    <a href="{{ route('admin.prodi.index') }}" class="btn btn-sm btn-secondary ms-2"><i
                                            class="fas fa-arrow-left"></i> Kembali</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </main>
@endsection
