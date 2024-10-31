@extends('admin.layouts.app')

@section('title', 'Edit Kategori Pelatihan')

@section('content')
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Edit Kategori Pelatihan</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active"><a href="/" class="text-decoration-none">Dashboard</a></li>
                <li class="breadcrumb-item active"><a href="{{ route('admin.kategori.index') }}"
                        class="text-decoration-none">Kategori Pelatihan</a></li>
                <li class="breadcrumb-item">Edit Kategori</li>
            </ol>

            <!-- Alert Messages -->
            @if (session('edit_success'))
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <strong>Update Berhasil!</strong> Kategori telah berhasil diperbarui.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h5><i class="fas fa-pen"></i> Edit Kategori</h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.kategori.update', $kategori->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="mb-3">
                                    <label for="nama" class="form-label">Nama Kategori</label>
                                    <input type="text" class="form-control @error('nama') is-invalid @enderror"
                                        name="nama" id="nama" value="{{ old('nama', $kategori->nama) }}" required>
                                    @error('nama')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="d-flex justify-content">
                                    <button type="submit" class="btn btn-primary"><i class="fas fa-pen"></i> Update</button>
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
