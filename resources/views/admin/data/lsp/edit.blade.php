@extends('admin.layouts.app')

@section('title', 'Edit LSP')

@section('content')
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">LSP</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active"><a href="/" class="text-decoration-none">Dashboard</a></li>
                <li class="breadcrumb-item active"><a href="{{ route('admin.lsp.index') }}"
                        class="text-decoration-none">LSP</a></li>
                <li class="breadcrumb-item">Edit Lsp</li>
            </ol>

            <!-- Alert Messages -->
            @if (session('edit_success'))
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <strong>Update Berhasil!</strong> LSP telah berhasil diperbarui.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h5><i class="fas fa-pen"></i> Edit LSP</h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.lsp.update', $lsp->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="mb-3 row">
                                    <label for="nama" class="form-label">Nama LSP</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="nama" id="nama"
                                            value="{{ old('nama', $lsp->nama) }}" placeholder="Masukkan Nama LSP">
                                        @error('nama')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="d-flex justify-content">
                                    <button type="submit" class="btn btn-primary"><i class="fas fa-pen"></i> Update</button>
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
