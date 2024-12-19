@extends('admin.layouts.app')

@section('title', 'Halaman Edit Prodi')

@section('content')
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Prodi</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active">
                    <a href="{{ route('admin.dashboard') }}" class="text-decoration-none">Dashboard</a>
                </li>
                <li class="breadcrumb-item active">
                    <a href="{{ route('admin.prodi.index') }}" class="text-decoration-none">Prodi</a>
                </li>
                <li class="breadcrumb-item">Edit Prodi</li>
            </ol>

            <!-- Alert Messages -->
            @if (session('edit_success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Edit Berhasil!</strong> Prodi telah berhasil diedit.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <!-- form Edit -->
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h5><i class="fas fa-pen"></i> Edit Prodi</h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.prodi.update', $prodi->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="mb-3">
                                    <label for="nama_prodi" class="form-label">Nama Prodi</label>
                                    <input type="text" class="form-control @error ('nama_prodi') is-invalid @enderror" name="nama_prodi" id="nama_prodi"
                                        placeholder="Masukan Nama Prodi" value="{{ old('nama_prodi', $prodi->nama_prodi) }}">
                                    @error('nama_prodi')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="jurusan_id" class="form-label">Jurusan</label>
                                    <select name="jurusan_id" id="jurusan_id" class="form-select @error ('jurusan_id') is-invalid @enderror">
                                        <option>-- Pilih Jurusan --</option>
                                        @foreach ($jurusans as $j )
                                            <option value="{{ $j->id }}" {{ old('jurusan_id', $prodi->jurusan_id) == $j->id ? 'selected' : '' }}>{{ $j->nama_jurusan }}</option>
                                        @endforeach
                                    </select>
                                    @error('jurusan_id')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="d-flex justify-content">
                                    <button type="submit" class="btn btn-sm btn-primary"><i class="fas fa-save"></i>
                                        Update</button>
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
