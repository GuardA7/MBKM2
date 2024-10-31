@extends('admin.layouts.app')

@section('title', 'Edit Jurusan')

@section('content')
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Jurusan</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active"><a href="/" class="text-decoration-none">Dashboard</a></li>
                <li class="breadcrumb-item active"><a href="{{ route('admin.jurusan.index') }}" class="text-decoration-none">Jurusan</a></li>
                <li class="breadcrumb-item">Edit Jurusan</li>
            </ol>

            <!-- Alert Messages -->
            @if (session('edit_success'))
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <strong>Update Berhasil!</strong> Jurusan telah berhasil diperbarui.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h5><i class="fas fa-pen"></i> Edit Jurusan</h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.jurusan.update', $jurusan->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="mb-3 row">
                                    <label for="nama_jurusan" class="form-label">Nama Jurusan</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="nama_jurusan" id="nama_jurusan"
                                            value="{{ old('nama_jurusan', $jurusan->nama_jurusan) }}" placeholder="Masukkan Nama Jurusan">
                                        @error('nama_jurusan')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="d-flex justify-content">
                                    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Update</button>
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
