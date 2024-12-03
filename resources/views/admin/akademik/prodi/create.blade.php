@extends('admin.layouts.app')

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
                <li class="breadcrumb-item">Tambah Prodi</li>
            </ol>

            <!-- form create -->
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h5><i class="fas fa-plus-circle"></i> Tambah Prodi</h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.prodi.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="mb-3">
                                    <label for="nama_prodi" class="form-label">Nama Prodi</label>
                                    <input type="text" class="form-control @error ('nama_prodi') is-invalid @enderror" name="nama_prodi" id="nama_prodi"
                                        placeholder="Masukan Nama Prodi" value="{{ old('nama_prodi') }}">
                                    @error('nama_prodi')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="jurusan_id" class="form-label">Jurusan</label>
                                    <select name="jurusan_id" id="jurusan_id" class="form-select @error ('jurusan_id') is-invalid @enderror">
                                        <option>-- Pilih Jurusan --</option>
                                        @foreach ($jurusan as $j )
                                            <option value="{{ $j->id }}" {{ old('jurusan_id') == $j->id ? 'selected' : '' }}>{{ $j->nama_jurusan }}</option>
                                        @endforeach
                                    </select>
                                    @error('jurusan_id')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="d-flex justify-content">
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
