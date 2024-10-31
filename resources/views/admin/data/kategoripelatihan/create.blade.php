@extends('admin.layouts.app')

@section('title', 'Edit LSP')

@section('content')
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Kategori Pelatihan</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active"><a href="/" class="text-decoration-none">Dashboard</a></li>
                <li class="breadcrumb-item active"><a href="{{ route('admin.kategori.index') }}" class="text-decoration-none">Kategori Pelatihan</a></li>
                <li class="breadcrumb-item">Tambah Kategori Pelatihan</li>
            </ol>

            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h5><i class="fas fa-plus-circle"></i> Tambah Kategori Pelatihan</h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.kategori.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="mb-3">
                                    <label for="nama" class="form-label">Nama Kategori</label>
                                    <input type="text" class="form-control" name="nama" id="nama" placeholder="Maukan Nama Kategori">
                                    @error('nama')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="d-flex justify-content">
                                    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan</button>
                                    <a href="{{ route('admin.kategori.index') }}" class="btn btn-secondary ms-2"><i class="fas fa-arrow-left"></i> Kembali</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
