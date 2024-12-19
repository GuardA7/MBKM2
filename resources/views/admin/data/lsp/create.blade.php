@extends('admin.layouts.app')

@section('title', 'Halaman Tambah Lsp')

@section('content')
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">LSP</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active">
                    <a href="{{ route('admin.dashboard') }}" class="text-decoration-none">Dashboard</a>
                </li>
                <li class="breadcrumb-item active">
                    <a href="{{ route('admin.lsp.index') }}" class="text-decoration-none">Lsp</a>
                </li>
                <li class="breadcrumb-item">Tambah LSP</li>
            </ol>

            <!-- tabel start -->
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h5><i class="fas fa-plus-circle"></i> Tambah Lsp</h5>
                        </div>
                        <div class="card-body">

                            <!-- form start create -->
                            <form action="{{ route('admin.lsp.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf

                                <!-- create nama lsp -->
                                <div class="mb-3">
                                    <label for="nama" class="form-label">Nama Kelas</label>
                                    <input type="text" class="form-control @error('nama') is-invalid @enderror"
                                        name="nama" id="nama" placeholder="Masukan Nama Lsp"
                                        value="{{ old('nama') }}">
                                    @error('nama')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- button -->
                                <div class="d-flex justify-content">
                                    <button type="submit" class="btn btn-sm btn-primary"><i class="fas fa-save"></i>
                                        Tambah</button>
                                    <a href="{{ route('admin.lsp.index') }}" class="btn btn-sm btn-secondary ms-2"><i
                                            class="fas fa-arrow-left"></i> Kembali</a>
                                </div>

                            </form>
                            <!-- form end create -->

                        </div>
                    </div>
                </div>
            </div>
            <!-- tabel end -->

        </div>
    </main>
@endsection
