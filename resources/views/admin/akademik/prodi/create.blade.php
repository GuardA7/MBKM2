@extends('admin.layouts.app')

@section('title', 'Tambah Prodi')

@section('content')
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Tambah Prodi</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active"><a href="/" class="text-decoration-none">Dashboard</a></li>
                <li class="breadcrumb-item">Prodi</li>
            </ol>

            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h5><i class="fas fa-plus-circle"></i> Tambah Prodi</h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.prodi.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf

                                <!-- Nama Prodi -->
                                <div class="mb-3">
                                    <label for="nama_prodi" class="form-label">Nama Prodi</label>
                                    <input type="text" name="nama_prodi"
                                        class="form-control @error('nama_prodi') is-invalid @enderror" id="nama_prodi"
                                        value="{{ old('nama_prodi') }}" placeholder="Masukan Nama Prodi">
                                    @error('nama_prodi')
                                        <span class="invalid-feedback"
                                            role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>

                                <!-- Jurusan Selection -->
                                <div class="mb-3">
                                    <label for="jurusan_id" class="form-label">Jurusan</label>
                                    <select name="jurusan_id" id="jurusan_id"
                                        class="form-select @error('jurusan_id') is-invalid @enderror" required>
                                        <option value="">-- Pilih Jurusan --</option>
                                        @foreach ($jurusans as $jurusan)
                                            <option value="{{ $jurusan->id }}"
                                                {{ old('jurusan_id') == $jurusan->id ? 'selected' : '' }}>
                                                {{ $jurusan->nama_jurusan }}</option>
                                        @endforeach
                                    </select>

                                    @error('jurusan_id')
                                        <span class="invalid-feedback"
                                            role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>

                                <button type="submit" class="btn btn-primary btn-sm">Tambah</button>
                                <a href="{{ route('admin.prodi.index') }}" class="btn btn-secondary btn-sm">Kembali</a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
