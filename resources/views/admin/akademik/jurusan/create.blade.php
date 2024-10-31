@extends('admin.layouts.app')

@section('title', 'Edit jurusan')

@section('content')
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Jurusan</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active"><a href="/" class="text-decoration-none">Dashboard</a></li>
                <li class="breadcrumb-item active"><a href="{{ route('admin.jurusan.index') }}" class="text-decoration-none">Jurusan</a></li>
                <li class="breadcrumb-item">Tambah Jurusan</li>
            </ol>

            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h5><i class="fas fa-plus-circle"></i> Tambah Jurusan</h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.jurusan.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="mb-3">
                                    <label for="nama_jurusan" class="form-label">Nama Jurusan</label>
                                    <input type="text" class="form-control" name="nama_jurusan" id="nama_jurusan" placeholder="Masukan Nama Jurusan">
                                    @error('nama_jurusan')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="d-flex justify-content">
                                    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan</button>
                                    <a href="{{ route('admin.jurusan.index') }}" class="btn btn-secondary ms-2"><i class="fas fa-arrow-left"></i> Kembali</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
