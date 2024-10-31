@extends('admin.layouts.app')

@section('title', 'Tambah LSP')

@section('content')
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">LSP</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active"><a href="/" class="text-decoration-none">Dashboard</a></li>
                <li class="breadcrumb-item active"><a href="{{ route('admin.lsp.index') }}" class="text-decoration-none">LSP</a></li>
                <li class="breadcrumb-item">Tambah LSP</li>
            </ol>

            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h5><i class="fas fa-plus-circle"></i> Tambah LSP</h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.lsp.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="mb-3">
                                    <label for="nama" class="form-label">Nama LSP</label>
                                    <input type="text" class="form-control" name="nama" id="nama" placeholder="Masukan Nama LSP" required>
                                    @error('nama')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="d-flex justify-content">
                                    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan</button>
                                    <a href="{{ route('admin.lsp.index') }}" class="btn btn-secondary ms-2"><i class="fas fa-arrow-left"></i> Kembali</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
